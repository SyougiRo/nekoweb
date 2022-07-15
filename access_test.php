<?php
    //include('access_db.php');
    include('myfunc.php');
    //echo add_cat_data(['err','black','white'],$tnr=true);
    //echo add_user('sample@gmail.com','admin',$is_root=true,$user_name='admin');

    //$user_id = Email_and_Pwd_get_user_id('sample@gmail.com','admin');
    //echo $user_id;
    //$imgfile= file_get_contents('F:\KIC\實驗室\python\jpg\rgb\IMG_0293.jpg');
    //$img_src = "data:image/jpeg;base64,".base64_encode($imgfile);
    //echo $img_src;
    //echo '<img src='.$img_src.' style="width:500px">';
    //echo add_tag_log($user_id,$gps=[34.652787, 135.498632],$time=time(),$img_src=$img_src,$address=['大阪府','大阪市','浪速区']);
    
    //$img_src = UserId_get_ImgSrc($user_id);
    //echo count($img_src);
    //echo '<img src="'.$img_src[0].'" style="width:500px;height=600px">';
    //print_r(get_NoDealLog());
    //兵庫県　神戸市　中央区
    //'大阪府','大阪市','中央区'
    //add_tag_log($user_id,$gps=[34.658661,135.1427767],$time=time(),$img_src=$img_src,$address=['兵庫県','神戸市','長田区']);
    //$img_src = ImgId_get_ImgSrc('62ae76eb74f894e4460fd7e4');
    //echo '<img src='.$img_src.' style="width:500px">';
    $array = address_list();
    foreach($array as $address1 )
    {
        echo '<br>';
        print_r(array_keys($address1));
        foreach($address1 as $address2) 
        {
            echo '<br>';
            print_r(array_keys($address2));
        }
    }
    //print_r($array['北海道・東北']['北海道']);
    
    //print_r($array['北海道・東北']);
?>