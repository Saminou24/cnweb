<?php

class SearchController extends Cab_Controller_Action {

    public function init() {
        Zend_Loader::loadClass("Zend_Search_Lucene");
        Zend_Loader::loadClass("PostModel");
    }

    public function indexAction() {
        $this->_response->setHeader("content-type", "text/html;charset=utf-8");
        $q = htmlentities(trim($this->_request->getParam('q')));
        $q = str_replace("+", " ", $q); //change + as space
        $query = PostModel::normalizeName($q);
        //open search engine
        $index = Zend_Search_Lucene::open("post");
        $result = $index->find($query);

        echo "<section data-type='list'><ul   id='search-result-list'>
                <header><span style='color:#000;font-size:2rem;font-weight:bold;'>" . count($result) . "</span> kết quả được tìm thấy</header>";
        ;
        foreach ($result as $r) {
//            $hlText = $this->highlight($q, " " . $r->title);
            echo '<li>
                        <a href="' . $r->link . '">
                            <p>   ' . stripslashes($r->title) . '</p>
                             <p></p>
                        </a>
                  </li>';
        }
        echo "</ul></section>";
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

    public function highlight($query, $str) {
        $hl = explode(" ", $query);

        foreach ($hl as $t) {
            // echo "highlight for ".$t." in".$str."</br>/$t/i";
            if (strlen($t) > 0)
//                str_replace($t, "<strong>".$t."</strong>", $str);
                @$str = preg_replace("/ $t/i", "<strong class='keyword'> $t</strong>", $str);
        }
        return $str;
    }

}