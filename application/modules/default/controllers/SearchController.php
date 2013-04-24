<?php

class SearchController extends Cab_Controller_Action {

    public function init() {
        Zend_Loader::loadClass("Zend_Search_Lucene");
        Zend_Loader::loadClass("PostModel");
    }

    public function indexAction() {
        $this->_response->setHeader("content-type", "text/html;charset=utf-8");
        $query = PostModel::normalizeName($this->_request->getParam('q'));

        //open search engine
        $index = Zend_Search_Lucene::open("post");
        $result = $index->find($query);

        // echo count($result) . " Kết quả được tìm thấy :<br/>";
        echo "<ul  data-type='edit'>";
        foreach ($result as $r) {
            $hlText = $this->highlight($rawQuery, " " . $r->title);
            echo '<li>
                        <a href="/search/?q=' . $r->title . '"><p>   ' . $hlText . '</p></a>
                  </li>';
        }
        echo "</ul>";
    }

    public function specialAction() {
        $index = new Zend_Search_Lucene("post", true);

        //set limit result
        //Zend_Search_Lucene::setResultSetLimit(10);
        //setup unicode
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
        Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('UTF-8');
        $doc = new Zend_Search_Lucene_Document();
        $index->addDocument($doc);
//        $contents = array(
//            'Google is greate one for our company. so when we are ready to make it, please make some time to be user for you',
//            'Apple is another sompany for using with some simple of the example for this one.',
//            'Microsoft is another one for the coming of the yeras for this one. It has windows',
//        );
//        $titles = array(
//            'Google is technology company mobile',
//            'Apple is mobile leader company',
//            'Microsoft is king for desktop',
//        );
//        $links = array(
//            'http://google.com',
//            'http://apple.com',
//            'http://microsoft.com',
//        );
//
//        for ($i = 0; $i < count($links); $i++) {
//            $doc->addField(Zend_Search_Lucene_Field::Keyword('link', $links[$i]));
//            $doc->addField(Zend_Search_Lucene_Field::Text('title', $titles[$i]));
//            $doc->addField(Zend_Search_Lucene_Field::Unstored('contents', $contents[$i]));
//        }
//

        $index->commit();
        echo $index->count() . " Documents indexed";
    }

    public function renderAction() {
        $request = $this->_request;

        $keyword = $this->getParam("q");

        $index = new Zend_Search_Lucene("lucene");
        $hit = $index->find($keyword);

        $output = '<div id="search">';
        $output .="<p>Total Index: " . $index->count() . " documents<p>";
        $output .= "<p>Search for: " . $keyword . " has resulted on " . count($hit) . "</p>";

        foreach ($hit as $r) {
            $output .= '<div id="item">';
            $output .= '<h2><a href="' . $r->link . '">' . $r->title . '</a> ' . $r->score . '</h2>';
            $output .= '</div>';
        }

        $output .='</div>';

        echo $output;
    }

}