<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Illuminate\Support\Facades\Storage;
use URL;

class makeSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    private function getInWeeks($storage)
    {
	define("RETRO_YEARS",5);
	$year_week = date('W-y');
	@unlink(storage_path('sitemap-'.$year_week.'.xml'));
	@unlink(storage_path('sitemap-'.$year_week.'.xml.gz'));
        $client = ClientBuilder::create()
            ->setHosts(config('database.connections.elasticsearch.hosts'))
            ->build();

        $query = [];
	for($y=0;$y<RETRO_YEARS;$y++)
	{
	    $df = strtotime("-".$y." year",time());
	    $dt = date("Y-m-d",strtotime('-1 week',$df));
	    $df = date("Y-m-d",$df);
	    $query[]=["range"=>["registration_date"=>["gt"=>$dt,"lt"=>$df]]];
	}
        $params = [
            'index' => env('ELASTICSEARCH_INDEX'),
            'body' => [
                'query' => [
                    'bool'=>[
                        'should'=>$query,
/*			'must_not'=>[
			    [
				'term'=> ['sitemapped'=>true]
			    ]
			]*/
                    ],
                ],
                '_source'=> [
                    'registration_number',
		    'registration_date'
                ]
            ],
	    'size'=>10000
        ];
        $response = $client->search($params);
	$fname = $storage.'/sitemap-'.$year_week.'.xml.gz';
	$fp = gzopen ($fname, 'w9');
	gzwrite($fp,"<?xml version=\"1.0\" encoding=\"UTF-8\"?><urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n");
	foreach($response['hits']['hits'] as $record)
	{
	    gzwrite($fp,"<url>\n\t<loc>".URL::to('/')."/ua/document/".$record['_source']['registration_number']."</loc>\n");
	    gzwrite($fp,"\t<lastmod>".date('c',strtotime($record['_source']['registration_date']))."</lastmod>\n</url>\n");
	    gzwrite($fp,"<url>\n\t<loc>".URL::to('/')."/en/document/".$record['_source']['registration_number']."</loc>\n");
	    gzwrite($fp,"\t<lastmod>".date('c',strtotime($record['_source']['registration_date']))."</lastmod>\n</url>\n");
    	    $params = [
        	'index' => env('ELASTICSEARCH_INDEX'),
//        	'body' => ['sitemapped'=>true],
		'body' =>['script'=> 'ctx._source.sitemapped = true'],
                'id'=>$record['_source']['registration_number']
    	    ];
    	    $client->update($params);
	}
	gzwrite($fp,"</urlset>");
	gzclose($fp);
    }

    private function otherPages($storage)
    {
	define("OTHER_NAME","sitemap-other.xml.gz");
	define("OTHER_PAGES",[
	    '/ua/search',
	    '/en/search',
	]);

	$fname = $storage.'/'.OTHER_NAME;
	$fp = gzopen ($fname, 'w9');
	gzwrite($fp,"<?xml version=\"1.0\" encoding=\"UTF-8\"?><urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n");
	foreach(OTHER_PAGES as $url)
	{
	    gzwrite($fp,"<url>\n\t<loc>".URL::to('/').$url."</loc>\n");
	    gzwrite($fp,"\t<lastmod>".date('c',time())."</lastmod>\n</url>\n");
	}
	gzwrite($fp,"</urlset>");
	gzclose($fp);
    }


    public function handle()
    {
	define("STORAGE",storage_path("app/public/sitemap"));
	define("ROOT_SITEMAP",STORAGE."/sitemap.xml");

	define("ROOT_ROBOTS",public_path()."/robots.txt");

	$this->getInWeeks(STORAGE);
	$this->otherPages(STORAGE);

	file_put_contents(ROOT_SITEMAP,"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n");
	file_put_contents(ROOT_ROBOTS,file_get_contents(public_path()."/robots.txt.tpl"));
	foreach(scandir(STORAGE) as $file)
	    if (substr($file,-3)=='.gz')
	    {
		file_put_contents(ROOT_SITEMAP,"<sitemap>\n\t<loc>".URL::to('/')."/storage/sitemap/".$file."</loc>\n</sitemap>\n",FILE_APPEND);
		file_put_contents(ROOT_ROBOTS,"Sitemap: ".URL::to('/')."/storage/sitemap/".$file."\n",FILE_APPEND);
	    }
	file_put_contents(ROOT_SITEMAP,'</sitemapindex>',FILE_APPEND);

    }
}
