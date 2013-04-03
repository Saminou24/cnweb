<?php

class SearchController extends Cab_Controller_Action {
    public function init(){
        Zend_Loader::loadClass("Zend_Search_Lucene");
    }
    public function indexAction(){
        $index = new Zend_Search_Lucene("lucene", true);
        
        $doc = new Zend_Search_Lucene_Document();
        
        $contents = array(
            'Google is greate one for our company. so when we are ready to make it, please make some time to be user for you',
            'Apple is another sompany for using with some simple of the example for this one.',
            'Microsoft is another one for the coming of the yeras for this one. It has windows',
        );
        $titles = array(
            'Google is technology company mobile',
            'Apple is mobile leader company',
            'Microsoft is king for desktop',
        );
        $links = array(
            'http://google.com',
            'http://apple.com',
            'http://microsoft.com',
        );
        
        for($i=0; $i<count($links); $i++){
            $doc->addField(Zend_Search_Lucene_Field::Keyword('link', $links[$i]));
            $doc->addField(Zend_Search_Lucene_Field::Text('title', $titles[$i]));
            $doc->addField(Zend_Search_Lucene_Field::Unstored('contents', $contents[$i]));
            $index->addDocument($doc);
        }
        
        
        $index->commit();
        echo $index->count()." Documents indexed";
    }
    public function renderAction(){
        $request = $this->_request;
        
        $keyword = $this->getParam("q");
        
        $index = new Zend_Search_Lucene("lucene");
        $hit =  $index->find($keyword);
        
        $output = '<div id="search">';
        $output .="<p>Total Index: ".$index->count(). " documents<p>";
        $output .= "<p>Search for: ".$keyword." has resulted on ".count($hit)."</p>";
        
        foreach ($hit as $r){
            $output .= '<div id="item">';
            $output .= '<h2><a href="'.$r->link.'">'.$r->title.'</a> '.$r->score.'</h2>';
            $output .= '</div>';
        }
        
        $output .='</div>';
        
        echo $output;
    }
}