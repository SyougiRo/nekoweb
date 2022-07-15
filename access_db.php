<?php
    $manager = null;
    $bulk = null;
    $writeConcern = null;
    $access_is_ok = false;

    function access_db()
    {
        global $manager;
        global $bulk;
        global $writeConcern;
        global $access_is_ok;

        $manager = new MongoDB\Driver\Manager();
        $bulk = new MongoDB\Driver\BulkWrite;
        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $access_is_ok = true;
    }

    function do_data($table_name,$work,$data=null,$opt=null,$relu=null)
    {
        global $manager;
        global $bulk;
        global $writeConcern;
        global $access_is_ok;

        if(!$access_is_ok)
        {
            access_db();
        }
        //print_r($data);
        switch($work)
        {
            case 'insert':                
                if(empty($opt))
                {                    
                    $bulk->insert($data);
                }
                else
                {                    
                    $bulk->insert($data,$opt);
                }
                break;
             
            case 'search':
                
                if(empty($opt))
                {
                    $query = new MongoDB\Driver\Query($data);
                }
                else
                {
                    $query = new MongoDB\Driver\Query($data,$opt);
                }
                $cursor = $manager->executeQuery($table_name, $query); //搜尋資料
                return($cursor);
                break;
              
            case 'update':
                if(empty($opt))
                {
                    $bulk->update($relu,$data);
                }
                else
                {
                    $bulk->update($relu,$data,$opt);
                }
                break;
            
            case 'delete':
                if(empty($opt))
                {
                    $bulk->delete($data);
                }
                else
                {
                    $bulk->delete($data,$opt);
                }
                break;
        }
        $result = $manager->executeBulkWrite($table_name, $bulk, $writeConcern);
    }

    function add_user($Email,$pwd,$is_root,$user_name)
    {
        $table_name = 'test.user';

        $work = 'insert';

        $user_data = [
            'user_Email'=>$Email,
            'pwd'=>$pwd,
            'is_root'=>$is_root,
            'user_name'=>$user_name
        ];

        do_data($table_name,$work,$user_data);

        return(1);
    }

    function Email_and_Pwd_get_user_id($Email,$pwd)
    {
        $table_name = 'test.user';

        $work='search';
        
        $user_data = [
            'user_Email'=>$Email,
            'pwd'=>$pwd,
        ];
        
        $output = do_data($table_name,$work,$user_data)->toArray();
        $res = current($output);
        
        if(empty($res))
        {
            return(0);
        }
        elseif(count($output)>1)
        {
            return(-1);
        }

        return($res->_id);
    }

    function add_cat_data($color_list,$tnr=false)
    {
        $table_name = 'test.cat';

        $work = 'insert';

        $cat_data = [
            'color'=>['red'=>0,'white'=>0,'black'=>0],
            'tnr'=>0
        ];

        foreach(array_keys($cat_data['color']) as $color)
        {
            if(in_array($color,$color_list))
            {
                $cat_data['color'][$color] = 1;
            }
        }

        if($tnr)
        {
            $cat_data['tnr'] = 1;
        }

        do_data($table_name,$work,$cat_data);

        return(1);
    }

    function add_tag_log($user_id,$gps,$time,$img_src,$address)
    {

        $table_name = 'test.taglog';
        $work = 'insert';

        $taglog = [
            'user_id'=>$user_id,
            'cat_id'=>null,
            'gps'=>$gps,
            'address'=>$address,
            'time'=>date("Y/m/d",$time),
            'img_src'=>$img_src,
            'deal_id'=>null
        ];

        do_data($table_name,$work,$taglog);

        return(1);
    }

    function UserId_get_ImgSrc($user_id)
    {
        $table_name = 'test.taglog';

        $work='search';

        $img_src_array=[];

        $taglog = [
            'user_id'=>$user_id
        ];

        $output = do_data( $table_name,$work,$taglog)->toArray();

        foreach ($output as $document)
        {
            $img_src_array[] = $document->img_src;
        }

        return($img_src_array);
    }

    function get_NoDealLog()
    {
        $table_name = 'test.taglog';

        $work='search';

        $log_array=[];

        $data = [
            'deal_id'=>null
        ];

        $output = do_data( $table_name,$work,$data)->toArray();
        //echo count($output).'<br>';
        foreach($output as $document)
        {
            $array_address = array($document->address)[0];
            $log_id = current($document->_id);
            $log_time = $document->time;
            $log_address_txt = do_formet($array_address[0]).do_formet($array_address[1]).do_formet($array_address[2]);

            $log_array[] = ['log_id'=>$log_id,'log_time'=>$log_time,'log_address_txt'=>$log_address_txt,'address1'=>$array_address[0],'address2'=>$array_address[1],'address3'=>$array_address[2]];
        }

        return($log_array);
    }

    function ImgId_get_ImgSrc($img_id)
    {
        $table_name = 'test.taglog';

        $work='search';

        $data=[
            '_id' => new \MongoDB\BSON\ObjectID($img_id)
        ];

        $output = do_data( $table_name,$work,$data)->toArray();

        $res = current($output)->img_src;
        //print_r($res->img_src);
        return($res);
    }

    function do_formet($txt)
    {
        $len = mb_strlen($txt);
        $spase = '　';
        $output_txt = '';
        for($count=0;$count<8-$len;$count++)
        {
            $output_txt = $output_txt.$spase;  
        }
        $output_txt = $output_txt.$txt;
        
        return($output_txt);
    }
?>