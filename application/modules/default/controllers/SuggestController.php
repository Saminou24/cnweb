<?php

class SuggestController extends Zend_Controller_Action {

    public function init() {
        //set no view render
        //$this->_helper->viewRender->setNoRender(true);
        Zend_Loader::loadClass("PostModel");
        $this->_helper->layout->disableLayout();
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive());
        Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('UTF-8');
    }

    public function preDispatch() {
        
    }

    public function indexAction() {
        $this->_response->setHeader("content-type", "text/html;charset=utf-8");
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive());
        Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('UTF-8');
        $rawQuery = trim($this->_request->getParam('q'));


        
        $query =  preg_replace('!\s+!', " ",PostModel::normalizeName($rawQuery));
//        die(strlen($query));
//        $last = explode(" ", $query);
//        $last = $last[count($last) - 1];
        
//        if (strlen($query) >= 2)
//            $query .= "*"; //use regex
        $index = Zend_Search_Lucene::open("post");
        $result = $index->find("keyword".$query);

        // echo count($result) . " Kết quả được tìm thấy :<br/>";
        echo "<ul  data-type='edit'>";
        foreach ($result as $r) {
            $hlText = $this->highlight($query,$r->keyword, $r->title);
//            die($hlText);
            $query_url = htmlspecialchars(preg_replace('!\s+!', "+", $r->title));
//            die($query);
            echo '<li>
                        <a href="/search/?q=' . $query_url . '"><p>   ' . $hlText . '</p></a>
                  </li>';
        }
        echo "</ul>";
    }

    public function highlight($query, $str1,$str2) {
        $hl = explode(" ", strtolower($query));
        $replaceArr = explode(" ", $str2);
        
        $str1 = explode(" ", strtolower($str1));
        foreach ($hl as $i=>$t) {
            while (($pos = array_search($t, $str1))!== FALSE){
//                   echo ("replace");
                $str1[$pos] = "<strong class='keyword'>".$replaceArr[$pos]."</strong>";
            }
        }
        return implode(" ", $str1);
//        foreach ($hl as $i=>$t) {
//            // echo "highlight for ".$t." in".$str."</br>/$t/i";
//            if (strlen($t) > 0) {
////                str_replace($t, "<strong>".$t."</strong>", $str);
//                $str = preg_replace("/ $t/i", "<strong class='keyword'> $replaceArr[$i]</strong>", $str1);
//            }
//        }
//        return $str;
    }

}