<?php
    function test_func()
    {
        $val_a = $_POST['val_a'];
        $val_b = $_POST['val_b'];

        $return_txt = json_encode(array('output_a'=> $val_a , 'output_b'=>$val_b));

        echo $return_txt;
    }

    function read_gps()
    {
        //$jpg = $_POST['jpg'];
        //fwrite("test.jpg",$jpg);
        $return_txt = json_encode(array('output_a'=> 'test' ));
        echo $return_txt;
    }

	function check_login()
	{
		if(isset($_POST['input_mail']))
		{
			$email = $_POST['input_mail'];
		}
		else
		{
			$txt = 'パスワードがない';
			echo_erro($txt);
		}
		if(isset($_POST['input_passw']))
		{
			$pwd = $_POST['input_passw'];
		}
		else
		{
			$txt = 'パスワードがない';
			echo_erro($txt);
		}
		
		$check_bool = ($email=='sample@gmail.com' && $pwd=='password');
		if(!$check_bool)
		{
			$txt = 'アカウントがない';
			echo_erro($txt);
			return;
		}
		$return_txt = json_encode(array('check_login'=> $check_bool ));
		echo $return_txt;
	}

	function echo_erro($txt)
	{
		$return_txt = json_encode(array('erro_txt'=> $txt ));
		echo $return_txt;
	}

	function get_nekodata()
	{
		
		$data = array(
			'data'=>[
				[
					'id'=>"0xjksdv456s",
					'see_time'=>"2022/01/03",
					'see_poj'=>'大阪府　大阪府　　　北区',
					'is_TNR'=>true
				],
				[
					'id'=>"0xjdrkskjds",
					'see_time'=>"2021/06/18",
					'see_poj'=>'大阪府　大阪府　天王寺区',
					'is_TNR'=>false
				],
				[
					'id'=>"05d46zrgdns",
					'see_time'=>"2021/10/28",
					'see_poj'=>'兵庫県　神戸市　　中央区',
					'is_TNR'=>false
				],
				[
					'id'=>"05d5rtjgdns",
					'see_time'=>"2021/11/08",
					'see_poj'=>'兵庫県　神戸市　　中央区',
					'is_TNR'=>true
				],
				[
					'id'=>"0xjsf9qskjds",
					'see_time'=>"2021/11/18",
					'see_poj'=>'大阪府　大阪府　天王寺区',
					'is_TNR'=>false
				],
				[
					'id'=>"05dzp646sj8",
					'see_time'=>"2021/11/28",
					'see_poj'=>'兵庫県　神戸市　　中央区',
					'is_TNR'=>false
				],
				[
					'id'=>"1dp5rtcok85",
					'see_time'=>"2021/12/08",
					'see_poj'=>'大阪府　大阪府　天王寺区',
					'is_TNR'=>true
				]
			]
		);
		
		$return_txt = json_encode($data);
		echo $return_txt;
	}

    if(isset($_POST['action']))
    {
        $action = $_POST['action'];
        switch($action)
        {
            case 'test_func':return(test_func());
            case 'read_gps':return(read_gps());
			case 'check_login':return(check_login());
			case 'get_nekodata':return(get_nekodata());
        }
    }
?>