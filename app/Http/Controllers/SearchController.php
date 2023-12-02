<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elastic\Elasticsearch\ClientBuilder;
// use Elastic\Elasticsearch\Response\Elasticsearch;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{

	const SEARCH_ITEM = "##search##";
	const SEARCH_LEVEL_ITEM = "##level##";
	const PER_PAGE = 100;
    const VIEW = 'pages.search';
    const PAGE = '/search';


    private $clearForm;
    private $sort;
    private $query;




    public function index(Request $request){
        if ($request->has('btnSearch')){
            return $this->doSearch($request);
        } else {
    	    return view(self::VIEW, ['fill' => $this->clearForm]);
        }
    }


    private function prepareData($field, $value){
        $field = preg_replace('/^search(.*)/', '$1', $field);
        if (empty($this->query[$field])){
            return false;
        }
        $validator = Validator::make([$field => $value], [$field => $this->query[$field]['validate'], 'Filter.*' => 'nullable|string|min:3'], __('validation.customMessages'));
        if ($validator->fails()){
            return ['result' => false, 'errors' => $validator->errors()];
        }
        $q = $this->query[$field]['query'];
        $level = 0;
        if (is_array($value)){
            $q['must'] = [];
            foreach($value as $v){
                $level++;
                $s = $this->query['Complex']['query']['should'];
                array_walk_recursive($s, function(&$item, $key) use ($field, $v, $level) {
                    if ($item == self::SEARCH_ITEM){
                        $item = $v;
                    }
                    $item = str_replace(self::SEARCH_LEVEL_ITEM, $field . $level, $item);
                });
                $q['must'][] = ['bool' => ['should' => $s]];
            }
        } else {
            array_walk_recursive($q, function(&$item, $key) use ($field, $value, $level) {
                if ($item == self::SEARCH_ITEM){
                    $item = $value;
                }
                $item = str_replace(self::SEARCH_LEVEL_ITEM, $field . $level, $item);
            });
        }
        return ['result' => true, 'query' => $q];
    }

    private function doSearch(Request $request){
        $fill = array_merge(
            $this->clearForm,
            array_map((fn($el) => empty($el) ? '' : $el), $request->all())
        );
        if ($request->has('searchFilter')){
            $arr = array_filter($request->input('searchFilter', []), fn($el) => !empty($el));
            $fill = array_merge($fill, ['searchFilter' => $arr]);
        }
        $hosts = config('database.connections.elasticsearch.hosts');
        $client = ClientBuilder::create()
            ->setBasicAuthentication(
                env('ELASTICSEARCH_USER', ''),
                env('ELASTICSEARCH_PASS','')
            )
	        ->setHosts($hosts)
	        ->build();
	    $must = [];
	    $should = [];
        foreach($request->all() as $var => $value){
            if (empty($value))
                continue;
            $tmp = $this->prepareData($var, $value);
            if (!$tmp)
                continue;
            if (!$tmp['result']) {
                return redirect()->back()->withErrors($tmp['errors'])->withInput($request->input());
            }
            if (isset($tmp['query']['must']))
                $must[] = $tmp['query']['must'];
            if (isset($tmp['query']['should']))
                $should[] = $tmp['query']['should'];
        }
        $m = [];
        foreach($must as $list)
            $m = array_merge($m, $list);
        $must = $m;

        $m = [];
        foreach($should as $list)
            $m = array_merge($m, $list);
        $should = $m;

        $sort = $request->input('sortOrder', 'registration_date');
        if (!isset($this->sort[$sort])){
            $sort = $this->sort['registration_number'];
        } else {
            $sort = $this->sort[$sort];
        }

        $page = $request->input('pa', 1);
        $params = [
            'index' => env('ELASTICSEARCH_INDEX', 'elastic/uacademic'),
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => $must,
                        'should' => $should
                    ],
                ],
                '_source' => [
                    'registration_number',
                    'registration_date',
                    'description'
                ],
                'highlight' => [
                    'pre_tags' => ['<span class="highlight">'],
                    'post_tags' => ['</span>'],
                    'fields' => [
                        'description.description_text' => [
                            'fragment_size' => 200,
                            'number_of_fragments' => 3
                        ],
                        'persons.person_names.name_full' => [
                            'fragment_size' => 200,
                            'number_of_fragments' => 3
                        ],
                        'full_texts.full_text' => [
                            'fragment_size' => 200,
                            'number_of_fragments' => 5
                        ]
                    ],
                    'max_analyzed_offset' => 900000
                ],
                'track_total_hits' => true,
                'sort' => (isset($sort['nested']) ? [$sort['field'] => ['order' => $sort['direction'], 'nested' => $sort['nested']]] : [$sort['field'] => ['order' => $sort['direction']]]),
                'from' => ($page - 1) * self::PER_PAGE, 'size' => self::PER_PAGE,
            ],
        ];


        /************************************************************************************************
         ************************************************************************************************
         */
        $data = '';
        $total = 10;
        $limited = false;
        return view(self::VIEW, compact('data', 'total', 'fill', 'limited'));
        /***** */


        if (count($should) || count($must)){
            $response = $client->search($params);
            $total = $response['hits']['total']['value'];
            $limited = false;
            if ($total > 1000) {
                $total = 1000;
                $limited = true;
            }
            $data = new LengthAwarePaginator($response['hits']['hits'], $total, self::PER_PAGE, $page, ['query' => $request->all(), 'path' => '/' . app()->getLocale() . self::PAGE, 'pageName' => 'pa']);
            return view(self::VIEW, compact('data', 'total', 'fill', 'limited'));
        } else {
            return view(self::VIEW, ['fill' => $this->clearForm]);
        }


    }

    public function __construct(){
        $this->clearForm = [
            'searchType' => 'okd',
            'sortOrder' => 'score',
        ];

        $this->sort = [
            'registration_date' => [
                'field' => 'registration_date',
                'direction' =>'desc',
            ],
            'author' => [
                'field' => 'persons.person_names.name_full.name',
                'direction' => 'asc',
                'nested' => [
                    'path' => 'persons'
                ]
            ],
            'score' => [
                'field' => '_score',
                'direction' => 'desc'
            ]
        ];

        $this->query = [
            'Filter' => [
                'validate' => 'nullable|array',
                'query' => []
            ],
            'DateTo' => [
                'validate' => 'nullable|date',
                'query' => ['must' => [['range' => [
                        'registration_date' => ['lte' => self::SEARCH_ITEM, 'format' => 'yyyy-MM-dd']
                    ]]]
                ]
            ],
            'DateFrom' => [
                'validate' => 'nullable|date',
                'query' => ['must' => [['range' => [
                        'registration_date' => ['gte' => self::SEARCH_ITEM, 'format' => 'yyyy-MM-dd']
                    ]]]
                ]
            ],
            'RegNo' => [
                'validate' => 'nullable|regex:/\d{4}U\d{6}/',
                'query' => ['must' => [['match' => [
                    'registration_number' => self::SEARCH_ITEM
                    ]]]
                ]
            ],
            'Author' => [
                'validate' => 'nullable|string|min:3',
                'query' => ['must' => [['nested' => [
                    'path' => 'persons',
                    'query' => [
                        'bool' => [
                            'must' => [
                                [
                                    'nested' => [
                                        'path' => 'persons.person_names',
                                        'query' => [
                                            'bool' => [
                                                'should' => [
                                                    /*
                                                    [
                                                        'fuzzy' => [
                                                            'persons.person_names.name_full' => [
                                                                'value' => self::SEARCH_ITEM,
                                                                'transpositions' => false,
                                                                'fuzziness' => 'AUTO',
                                                                'rewrite' => 'constant_score',
                                                            ]
                                                        ]
                                                    ],
                                                    */
                                                    [
                                                        'match_phrase_prefix' => [
                                                            'persons.person_names.name_full' => [
                                                                'query' => self::SEARCH_ITEM,
                                                                'boost' => 2,
                                                            ]
                                                        ]
                                                    ],
                                                ]
                                            ]
                                        ],
                                        'inner_hits' => ['sort' => ['persons.person_names.name_full' => ['order' => 'asc']]]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]]]]
            ],
            'Content' => [
                'validate' => 'nullable|string|min:10',
                'query' => ['must' => [['nested' => [
        		    'path' => 'full_texts',
        		    'query' => [
            		    'bool' => [
            			    'must' => [
                		        [
                            		'match' => ['full_texts.full_text' => self::SEARCH_ITEM]
                                ]
				            ]
			            ]
			        ],
			        'inner_hits' => ['name' => self::SEARCH_LEVEL_ITEM, '_source' => false]
		        ]]]]
	        ],
            'Theme' => [
                'validate' => 'nullable|string|min:10',
                'query' => ['must' => [['nested' => [
        		    'path' => 'description',
        		    'query' => [
            		    'bool' => [
            			    'must' => [
                		        [
                            		'match_phrase_prefix' => ['description.description_text' => self::SEARCH_ITEM]
				                ]
				            ]
			            ]
			        ],
			        'inner_hits' => ['name' => self::SEARCH_LEVEL_ITEM, '_source' => false]
		        ]]]]
    	    ],
            'Complex' => [
                'validate' => 'nullable|string|min:5',
                'query' => ['should' => [
				    [
                        'match' => [
                            'registration_number' => self::SEARCH_ITEM
                        ]
                    ],
                    [
                        'nested' => [
        				    'path' => 'persons',
        					'query' => [
            					'bool' => [
            						'must' => [
                					    [
                                            'nested' => [
                                                'path' => 'persons.person_names',
                                                'query' => [
                                                    'bool' => [
                                                        'should' => [
                                                            [
                                                                'fuzzy' => [
                                                                    'persons.person_names.name_full' => [
                                                                        'value' => self::SEARCH_ITEM,
                                                                        'transpositions' => false,
                                                                        'fuzziness' => 'AUTO',
                                                                        'rewrite' => 'constant_score',
                                                                        'boost' => 9
                                                                    ]
                                                                ]
                                                            ],
                                                            [
                                                                'match' => [
                                                                    'persons.person_names.name_full' => [
                                                                        'query' => self::SEARCH_ITEM,
                                                                        'boost' => 10
                                                                    ]
                                                                ]
                                                            ],
                                                        ]
                                                    ]
                                                ]
                                            ]
							            ]
							        ]
						        ]
						    ],
					        'inner_hits' => ['name' => self::SEARCH_LEVEL_ITEM . '_person', '_source' => false]
					    ]
                    ],
                    [
                        'nested' => [
                            'path' => 'full_texts',
                            'query' => [
                                'bool' => [
                                    'must' => [
                                        [
                                            'match' => [
                                                'full_texts.full_text' => [
                                                    'query' => self::SEARCH_ITEM,
                                                    'boost' => 1
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'inner_hits' => ['name' => self::SEARCH_LEVEL_ITEM . '_text', '_source' => false]
                        ]
                    ],
                    [
                        'nested' => [
                            'path' => 'description',
                            'query' => [
                                'bool' => [
                                    'must' => [
                                        [
                                            'match' => [
                                                'description.description_text' => [
                                                    'query' => self::SEARCH_ITEM,
                                                    'boost' => 5
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'inner_hits' => ['name' => self::SEARCH_LEVEL_ITEM . '_description', '_source' => false]
                        ]
                    ],
                ]]
            ],
        ];

    }

}
