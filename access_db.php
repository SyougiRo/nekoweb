<?php
    $manager = null;
    $bulk = null;
    $writeConcern = null;
    $access_is_ok = false;
    $database = 'test';

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

    function do_id($_id=null)
    {
        return new MongoDB\BSON\ObjectID($_id);
    }

    function re($key,$opt='i')
    {
        return new MongoDB\BSON\Regex($key,$opt);
    }

    function add_user($Email,$pwd,$user_name)
    {
        global $database;
        $table_name = $database.'.user';

        $work = 'insert';

        $user_data = [
            '_id' =>do_id(),
            'user_Email'=>$Email,
            'pwd'=>$pwd,
            'checker'=>'null',
            'user_name'=>$user_name,
            'root_level' => '10'
        ];

        if(Email_and_Pwd_get_user_id($Email,$pwd)==0)
        {
            do_data($table_name,$work,$user_data);

            $output = Email_and_Pwd_get_user_id($Email,$pwd);

            return($output);
        }
        else
        {
            return(0);
        }        
    }

    function search_some_cat($color,$lat_min,$lat_max, $lng_min, $lng_max)
    {
        global $database;
        $table_name = $database.'.cat';

        $work = 'search';
        $data = [
            'color'   => $color,
            'lat'     => ['$gte'=>(string)$lat_min,'$lte'=>(string)$lat_max],
            'lng'     => ['$gte'=>(string)$lng_min,'$lte'=>(string)$lng_max],
            'isfirst' => 'true',
            'ispass' => 'true',
        ];

        $output = do_data($table_name,$work,$data)->toArray();

        return($output);
    }

    function search_userName($key)
    {
        global $database;
        $table_name = $database.'.user';

        $work = 'search';

        $re = re($key);

        $data = [
            'user_name' => $re
        ];

        $opt=[
            'projection' => ['user_name'=>1,'_id'=>1,'root_level'=>1]
        ];

        $output = do_data($table_name,$work,$data,$opt)->toArray();

        return($output);
    }

    function Id_get_rootLevel($id)
    {
        global $database;
        $table_name = $database.'.user';
        $work = 'search';

        $id = do_id($id);

        $data = [
            '_id' => $id
        ];

        $opt=[
            'projection' => ['root_level'=>1]
        ];

        $output = do_data($table_name,$work,$data,$opt)->toArray();

        return($output);
    }

    function add_cat_data($src, $color, $tnr, $lat, $lng, $fu, $shi, $ku, $user_id,$msg ,$is_first,$cat_id=null,$ispass='true')
    {
        global $database;
        $table_name = $database.'.cat';
        $work = 'insert';

        $date  = date("j, n, Y");
        $now   = explode(", ", $date);
        $year  = $now[2];
        $month = $now[1];
        $day   = $now[0];

        if($is_first=='true')
        {
            $cat_id=do_id();
            $oid = $cat_id;
        }
        else
        {
            $oid = do_id();
            $cat_id=do_id($cat_id);
        }

        $data = check_img_only($src);
        if($data)
        {
            return(['erro'=>'has1']);
        }
        else
        {
            $cat_data = [
                '_id'     => $oid,
                'src'     => $src,
                'color'   => $color,
                'tnr'     => $tnr,
                'lat'     => $lat,
                'lng'     => $lng,
                'cat_id'  => $cat_id,
                'user_id' => $user_id,
                'fu'      => $fu,
                'shi'     => $shi,
                'ku'      => $ku,
                'isfirst' => $is_first,
                'ispass'  => $ispass,
                'year'    => $year,
                'month'   => $month,
                'day'     => $day,
                'msg'     => $msg
            ];

            do_data($table_name,$work,$cat_data);

            $return_data = get_cat_data($cat_data);

            return($return_data);
        }
    }

    function check_img_only($src)
    {
        global $database;
        $table_name = $database.'.cat';

        $work = 'search';

        $data = [
            'src' => $src
        ];

        $output = do_data($table_name,$work,$data)->toArray();
        $res = current($output);

        if(empty($res))
        {
            return(0);
        }
        else
        {
            return(1);
        }
    }

    function get_cat_data($cat_data)
    {
        global $database;
        $table_name = $database.'.cat';

        $work = 'search';

        $output = do_data($table_name,$work,$cat_data)->toArray();

        $res = current($output);
        
        if(empty($res))
        {
            return(0);
        }
        elseif(count($output)>1)
        {
            return(-1);
        }

        return($res);
    }

    function Email_and_Pwd_get_user_id($Email,$pwd)
    {
        global $database;
        $table_name = $database.'.user';

        $work='search';
        
        $user_data = [
            'user_Email'=>$Email,
            'pwd'=>$pwd,
        ];
        
        $output = do_data($table_name,$work,$user_data)->toArray();
        
        
        if(count($output)==0)
        {
            $output['email']=$Email;
            $output['pwd'] = $pwd;
            $output['erro']='no_acc';
        }
        elseif(count($output)>1)
        {
            $output['email']=$Email;
            $output['pwd'] = $pwd;
            $output['erro']='over_acc';
        }

        return($output);
    }
    
    function add_tag_log($user_id,$gps,$time,$img_src,$address)
    {
        global $database;
        $table_name = $database.'.taglog';

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
        global $database;
        $table_name = $database.'.taglog';

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
        global $database;
        $table_name = $database.'.taglog';

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
        global $database;
        $table_name = $database.'.taglog';

        $work='search';

        $data=[
            '_id' => new \MongoDB\BSON\ObjectID($img_id)
        ];

        $output = do_data( $table_name,$work,$data)->toArray();

        $res = current($output)->img_src;
        //print_r($res->img_src);
        return($res);
    }

    function get_CatArray_form_UserId($user_id)
    {
        global $database;
        $table_name = $database.'.cat';

        $work='search';

        $data=[
            'user_id' => $user_id,
        ];

        $opt=[
            'projection' => ['_id'=>1]
        ];

        $output = do_data( $table_name,$work,$data,$opt)->toArray();

        return($output);
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

    function CatId_get_array($cat_id)
    {
        global $database;
        $table_name = $database.'.cat';

        $work='search';

        $data=[
            'cat_id' => do_id($cat_id),
        ];
        $opt=[
            'projection' => ['src'=>1]
        ];

        $output = do_data( $table_name,$work,$data,$opt)->toArray();

        return($output);
    }

    function IdGatImg($cat_id)
    {
        global $database;
        $table_name = $database.'.cat';

        $work='search';

        $data=[
            '_id' => do_id($cat_id),
        ];
        $opt=[
            'projection' => ['_id'=>1,'src'=>1]
        ];

        $output = do_data( $table_name,$work,$data,$opt)->toArray();

        return($output);
    }

    function catIdGatAll($cat_id)
    {
        global $database;
        $table_name = $database.'.cat';

        $work='search';

        $data=[
            '_id' => do_id($cat_id),
        ];

        $output = do_data( $table_name,$work,$data)->toArray();

        return($output);
    }

    function isTnrCount($fushiku,$addr)
    {
        global $database;
        $table_name = $database.'.cat';

        $work='search';

        $data=[
            'isfirst' => 'true',
            'tnr'=>'1',
            'ispass'=>'true'
        ];

        if($fushiku!='all')
        {
            $data[$fushiku] = $addr;
        }

        $opt=[
            'projection' => ['_id'=>1]
        ];

        $output = do_data( $table_name,$work,$data,$opt)->toArray();

        $count = count($output);

        return($count);
    }

    function noTnrCount($fushiku,$addr)
    {
        global $database;
        $table_name = $database.'.cat';

        $work='search';

        $data=[
            'isfirst' => 'true',
            'tnr'=>'0',
            'ispass'=>'true'
        ];

        if($fushiku!='all')
        {
            $data[$fushiku] = $addr;
        }

        $opt=[
            'projection' => ['_id'=>1]
        ];

        $output = do_data( $table_name,$work,$data,$opt)->toArray();

        $count = count($output);

        return($count);
    }

    function get_year_count($year,$fushiku,$addr)
    {
        global $database;
        $table_name = $database.'.cat';

        $work='search';

        $data=[
            'isfirst' => 'true',
            'year'=>strval($year),
            'ispass'=>'true'
        ];

        if($fushiku!='all')
        {
            $data[$fushiku] = $addr;
        }

        $opt=[
            'projection' => ['_id'=>1]
        ];

        $output = do_data( $table_name,$work,$data,$opt)->toArray();

        $count = count($output);

        return($count);
    }

    function update_level($tag_id,$user_id,$level)
    {
        global $database;
        $table_name = $database.'.user';

        $work='update';

        $data = [
            '$set' => ['root_level'=>$level,'checker'=>do_id($user_id)]
        ];
        $opt = [];
        $relu = ['_id'=>do_id($tag_id)];
        do_data( $table_name,$work,$data,$opt,$relu);

        return;
    }

    function search_cat($fushiku='all',$addr='all',$color='all',$fu='------',$shi='------',$ku='------')
    {
        global $database;
        $table_name = $database.'.cat';

        $work='search';
        
        $data=[
            'isfirst' => 'true',
            'ispass'=>'true',
            
        ];

        if($fu!='------')
        {
            $data['fu'] =' '.$fu;
            /*
            $data = [
                'fu'=>' '.$fu,
            ];
            */
        }
        if($shi!='------')
        {
            $data['shi'] = str_replace('--',' ',$shi);
        }
        if($ku!='------')
        {
            $data['ku'] = str_replace('----',' ',$ku);
        }

        if($color!='all')
        {
            $data['color']= $color;
        }

        $opt=[
            'projection' => ['_id'=>1,'src'=>1]
        ];

        $output = do_data( $table_name,$work,$data,$opt)->toArray();

        return($output);
    }

    function addMessage($user_name,$txt,$now,$fu=null,$shi=null,$ku=null)
    {
        global $database;
        $table_name = $database.'.message';
        $work = 'insert';

        $data=[
            'user_name' => $user_name,
            'txt'=>$txt,
            'time'=>$now,      
        ];
        if($fu!=null)
        {
            $data['fu'] = ' '.$fu;
        }
        if($shi!=null)
        {
            $data['shi'] = str_replace('--',' ',$shi);
        }
        if($ku!=null)
        {
            $data['ku'] = str_replace('--',' ',$ku);
        }

        do_data($table_name,$work,$data);
    }

    function UserId_get_UserName($user_id)
    {
        global $database;
        $table_name = $database.'.user';

        $work='search';
        
        $data = [
            '_id'=>do_id($user_id),
        ];

        $opt=[
            'projection' => ['user_name'=>1]
        ];

        $output = do_data( $table_name,$work,$data,$opt)->toArray();
        //print_r($output[0]->{'user_name'});
        return($output[0]->{'user_name'});
    }

    function getMessage($fu=null,$shi=null,$ku=null)
    {
        global $database;
        $table_name = $database.'.message';

        $work='search';
        $data =[];

        if($fu!=null)
        {
            $data['fu'] = ' '.$fu;
        }
        if($shi!=null)
        {
            $data['shi'] = str_replace('--',' ',$shi);
        }
        if($ku!=null)
        {
            $data['ku'] = str_replace('----',' ',$ku);
        }

        $output = do_data( $table_name,$work,$data)->toArray();

        return($output);
        
    }

    function getTnrArray($fushiku='all',$addr='all',$fu='------',$shi='------',$ku='------')
    {
        global $database;
        $table_name = $database.'.tnr_log';

        $work='search';

        $data = [];

        
        if($fu!='------')
        {
            $data['fu'] =' '.$fu;
            /*
            $data = [
                'fu'=>' '.$fu,
            ];
            */
        }
        if($shi!='------')
        {
            $data['shi'] = str_replace('--',' ',$shi);
        }
        if($ku!='------')
        {
            $data['ku'] = str_replace('----',' ',$ku);
        }
            
        

        $output = do_data( $table_name,$work,$data)->toArray();
        /*
        if(count($output)<1)
        {
            $data = [];
            $output = do_data( $table_name,$work,$data)->toArray();
        }
        */
        return($output);
    }

    function insertTnrData($user_id,$count,$time_str,$lat,$lon,$fu,$shi,$ku)
    {
        global $database;
        $table_name = $database.'.tnr_log';

        $work='insert';

        $data=[
            'user_id' => do_id($user_id),
            'count'=>$count,
            'txt'=>$time_str,
            'fu' =>$fu,
            'shi'=>$shi,
            'ku'=>$ku,
            'lat'=>$lat,
            'lon'=>$lon          
        ];

        do_data($table_name,$work,$data);
    }

    function deleteCatDeta($img_id)
    {
        global $database;
        $table_name = $database.'.cat';
        $work='delete';

        $data = [
            '_id'=>do_id($img_id)
        ];

        $opt = ['limit' => 1];

        do_data($table_name,$work,$data,$opt);
    }
?>