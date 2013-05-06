<?php

class AjaxController extends Cab_Controller_Action {

    public function init() {
        $this->_helper->layout->disableLayout();
        Zend_Loader::loadClass("PostModel");
        Zend_Loader::loadClass("LikeModel");
    }

    public function preDispatch() {
        $this->_helper->layout->disableLayout();
    }

    public function indexAction() {
        //check session 
        $session = new Zend_Session_Namespace("user");


        $request = $this->getRequest();
        $action = $request->getParam("act");
        switch ($action) {
            case "like":
                if (!$session->uid) {
                    return;
                }
                $type = $request->getParam("type");
                $targetId = $request->getParam("id");
                Zend_Loader::loadClass("LikeModel");
                $model = new LikeModel();
                if (is_numeric($targetId)) {
                    $status = $model->like(array(
                        "uid" => $session->uid,
                        "targetId" => $targetId,
                        "type" => $type
                    ));
                    echo $status;
                }
                else
                    echo "error";
                break;
            case "check_status":
                echo $session->uid ? 1 : 0;
                break;
            case "load_more";
                $p = $request->getParam("page");
                $model = new PostModel();
                $likeModel = new LikeModel();
                $data = PostModel::getHotPage($p);

                foreach ($data as $i => $info) {
                    $relative_time = TimeUtil::calRelativeTime($info['date-created']);
                    if ($session->uid)
                        $like_status = $likeModel->getStatus(array(
                            'uid' => $session->uid,
                            "targetId" => $info['pid'],
                            "type" => "photo"
                        ));
                    else
                        $like_status = null;
                    $like_count = $likeModel->getLikeByTargetId($info['pid'], "photo");
                    ?><section class="post-item" >
                        <a href='<?= "/c/" . $info['pid'] ?>' class='post-image' target='_blank'>
                            <?php
                            if ($info['type'] == "photo")
                                echo "<img src='/photos/medium/" . $info['name'] . "' width='100%' />";
                            else
                                echo "<img src='http://img.youtube.com/vi/" . $info['name'] . "/0.jpg' width='100%' class='post-video'/> 
                            <div class='video-indicator'></div>";
                            ?>
                        </a>
                        <section class='post-info' data-type="list">
                            <header>
                                <?= stripcslashes($info['title']) ?> 
                            </header>
                            <ul>
                                <li>
                                    <aside class="icon">
                                        <a href="/uploader/<?php echo $info['uid'] ?>" ><img src="/photos/avatar/<?= $info['avatar'] ?> " alt="<?php echo $info['username'] ?>"/></a>
                                    </aside>
                                    <a href="http://cnweb/c/<?= $info['pid'] ?>" >

                                        <p>
                                            <input type='hidden' class='id' value='<?php echo $info['pid'] ?>' like-status='<?php echo $like_status; ?>' />
                                            <span class='post-like'><?= $like_count ?></span> &nbsp; &nbsp;
                                            <span class='post-comment'><?= $info['comment'] ?></span> &nbsp; &nbsp;
                                            <span class="fb-like" data-href="http://cnweb/c/<?= $info['pid'] ?>/" data-send="false" data-layout="button_count" data-width="60" data-show-faces="false"></span>

                                        </p>
                                        <p>
                                            <?= $relative_time ?> bởi <?php echo "<span class='link' href='/uploader/" . $info['uid'] . "'> <strong>" . $info['username'] . "</strong></span>"; ?>

                                        </p>
                                    </a>

                                </li>
                            </ul>

                        </section>

                    </section>
                    <?php
                }
                break;
        }
    }

}
