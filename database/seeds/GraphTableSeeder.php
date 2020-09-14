<?php

use Illuminate\Database\Seeder;
use App\Graph;
use App\MeasureGraph;
class GraphTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i=0; $i < 4; $i++) { 
        	$graph=new Graph();
	    	$graph->title="Grafica ".($i+1);
	    	$graph->description="Grafica ".($i+1);
	    	$graph->save();

            for ($j=0; $j < 2; $j++) { 
                $measureGraph=new MeasureGraph();
                $measureGraph->id_graph=$graph->id;
                $measureGraph->save();
            }
        }

        
    }
}
