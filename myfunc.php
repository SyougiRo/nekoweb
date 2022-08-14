<?php
	include('access_db.php');

	function dogeopy()
	{
		$gps = $_POST['gps'];
		$str_command = 'python3 dogeopy.py {\"lat\":'+$gps[0]+',\"lng\":'+$gps[1]+'}';
		exec($str_command,$output_json);
		$data = json_decode($output_json[0]);
	}

	function getGpsLimit()
	{
		$gps = $_POST['gps'];
		$str_command = 'python3 get_GpsLimit.py {\"lat\":'+$gps[0]+',\"lng\":'+$gps[1]+'}';
		exec($str_command,$output_json);
		$data = json_decode($output_json[0]);
	}

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
		$user_id = Email_and_Pwd_get_user_id($email,$pwd);
		
		$return_txt = json_encode(
			$user_id
		);

		echo $return_txt;
	}

	function echo_erro($txt)
	{
		$return_txt = json_encode(array('erro_txt'=> $txt ));
		echo $return_txt;
	}

	function get_nekodata()
	{
		$data = get_NoDealLog();
		
		$return_txt = json_encode($data);
		echo $return_txt;
	}

	function get_src()
	{
		$img_id = $_POST['img_id'];
		$data = ImgId_get_ImgSrc($img_id);
		$return_txt = json_encode($data);
		echo $return_txt;
	}

	function address_list()
	{
		$address_data =
		[
			'北海道・東北'=>
			[
				'北海道'=>
				[
					'札幌市'=>
					[
						'中央区'=>null,
						'北区'=>null,
						'東区'=>null,
						'白石区'=>null,
						'豊平区'=>null,
						'南区'=>null,
						'西区'=>null,
						'厚別区'=>null,
						'手稲区'=>null,
						'清田区'=>null
					],
					'函館市'=>null,
					'小樽市'=>null,
					'旭川市'=>null,
					'室蘭市'=>null,
					'釧路市'=>null,
					'帯広市'=>null,
					'北見市'=>null,
					'夕張市'=>null,
					'岩見沢市'=>null,
					'網走市'=>null,
					'留萌市'=>null,
					'苫小牧市'=>null,
					'稚内市'=>null,
					'美唄市'=>null,
					'芦別市'=>null,
					'江別市'=>null,
					'赤平市'=>null,
					'紋別市'=>null,
					'士別市'=>null,
					'名寄市'=>null,
					'三笠市'=>null,
					'根室市'=>null,
					'千歳市'=>null,
					'滝川市'=>null,
					'砂川市'=>null,
					'歌志内市'=>null,
					'深川市'=>null,
					'富良野市'=>null,
					'登別市'=>null,
					'恵庭市'=>null,
					'伊達市'=>null,
					'北広島市'=>null,
					'石狩市'=>null,
					'北斗市'=>null
				],
				'青森県'=>
				[
					'青森市'=>null,
					'弘前市'=>null,
					'八戸市'=>null,
					'黒石市'=>null,
					'五所川原市	'=>null,
					'十和田市'=>null,
					'三沢市'=>null,
					'むつ市'=>null,
					'つがる市'=>null,
					'平川市'=>null
				],
				'岩手県'=>
				[
					'盛岡市'=>null,
					'宮古市'=>null,
					'大船渡市'=>null,
					'花巻市'=>null,
					'北上市'=>null,
					'久慈市'=>null,
					'遠野市'=>null,
					'一関市'=>null,
					'陸前高田市'=>null,
					'釜石市'=>null,
					'二戸市'=>null,
					'八幡平市'=>null,
					'奥州市'=>null,
					'滝沢市'=>null
				],
				'宮城県'=>
				[
					'仙台市'=>
					[
						'青葉区'=>null,
						'宮城野区'=>null,
						'若林区'=>null,
						'太白区'=>null,
						'泉区'=>null
					],
					'石巻市'=>null,
					'塩竈市'=>null,
					'気仙沼市'=>null,
					'白石市'=>null,
					'名取市'=>null,
					'角田市'=>null,
					'多賀城市'=>null,
					'岩沼市'=>null,
					'登米市'=>null,
					'栗原市'=>null,
					'東松島市'=>null,
					'大崎市'=>null,
					'富谷市'=>null
				],
				'秋田県'=>
				[
					'秋田市'=>null,
					'能代市'=>null,
					'横手市'=>null,
					'大館市'=>null,
					'男鹿市'=>null,
					'湯沢市'=>null,
					'鹿角市'=>null,
					'由利本荘市'=>null,
					'潟上市'=>null,
					'大仙市'=>null,
					'北秋田市'=>null,
					'にかほ市'=>null,
					'仙北市'=>null
				],
				'山形県'=>
				[
					'山形市'=>null,
					'米沢市'=>null,
					'鶴岡市'=>null,
					'酒田市'=>null,
					'新庄市'=>null,
					'寒河江市'=>null,
					'上山市'=>null,
					'村山市'=>null,
					'長井市'=>null,
					'天童市'=>null,
					'東根市'=>null,
					'尾花沢市'=>null,
					'南陽市'=>null
				],
				'福島県'=>
				[
					'福島市'=>null,
					'会津若松市'=>null,
					'郡山市'=>null,
					'いわき市'=>null,
					'白河市'=>null,
					'須賀川市'=>null,
					'喜多方市'=>null,
					'相馬市'=>null,
					'二本松市'=>null,
					'田村市'=>null,
					'南相馬市'=>null,
					'伊達市'=>null,
					'本宮市'=>null
				]
			],
			'関東'=>
			[
				'茨城県'=>
				[
					'水戸市'=>null,
					'日立市'=>null,
					'土浦市'=>null,
					'古河市'=>null,
					'石岡市'=>null,
					'結城市'=>null,
					'龍ケ崎市'=>null,
					'下妻市'=>null,
					'常総市'=>null,
					'常陸太田市'=>null,
					'高萩市'=>null,
					'北茨城市'=>null,
					'笠間市'=>null,
					'取手市'=>null,
					'牛久市'=>null,
					'つくば市'=>null,
					'ひたちなか市'=>null,
					'鹿嶋市'=>null,
					'潮来市'=>null,
					'守谷市'=>null,
					'常陸大宮市'=>null,
					'那珂市'=>null,
					'筑西市'=>null,
					'坂東市'=>null,
					'稲敷市'=>null,
					'かすみがうら市'=>null,
					'桜川市'=>null,
					'神栖市'=>null,
					'行方市'=>null,
					'鉾田市'=>null,
					'つくばみらい市'=>null,
					'小美玉市'=>null
				],
				'栃木県'=>
				[
					'宇都宮市'=>null,
					'足利市'=>null,
					'栃木市'=>null,
					'佐野市'=>null,
					'鹿沼市'=>null,
					'日光市'=>null,
					'小山市'=>null,
					'真岡市'=>null,
					'大田原市'=>null,
					'矢板市'=>null,
					'那須塩原市'=>null,
					'さくら市'=>null,
					'那須烏山市'=>null,
					'下野市'=>null
				],
				'群馬県'=>
				[
					'前橋市'=>null,
					'高崎市'=>null,
					'桐生市'=>null,
					'伊勢崎市'=>null,
					'太田市'=>null,
					'沼田市'=>null,
					'館林市'=>null,
					'渋川市'=>null,
					'藤岡市'=>null,
					'富岡市'=>null,
					'安中市'=>null,
					'みどり市'=>null
				],
				'埼玉県'=>
				[
					'さいたま市'=>
					[
						'西区'=>null,
						'北区'=>null,
						'大宮区'=>null,
						'見沼区'=>null,
						'中央区'=>null,
						'桜区'=>null,
						'浦和区'=>null,
						'南区'=>null,
						'緑区'=>null,
						'岩槻区'=>null
					],
					'川越市'=>null,
					'熊谷市'=>null,
					'川口市'=>null,
					'行田市'=>null,
					'秩父市'=>null,
					'所沢市'=>null,
					'飯能市'=>null,
					'加須市'=>null,
					'本庄市'=>null,
					'東松山市'=>null,
					'春日部市'=>null,
					'狭山市'=>null,
					'羽生市'=>null,
					'鴻巣市'=>null,
					'深谷市'=>null,
					'上尾市'=>null,
					'草加市'=>null,
					'越谷市'=>null,
					'蕨市'=>null,
					'戸田市'=>null,
					'朝霞市'=>null,
					'志木市'=>null,
					'和光市'=>null,
					'新座市'=>null,
					'桶川市'=>null,
					'久喜市'=>null,
					'北本市'=>null,
					'八潮市'=>null,
					'富士見市'=>null,
					'三郷市'=>null,
					'蓮田市'=>null,
					'坂戸市'=>null,
					'幸手市'=>null,
					'鶴ヶ島市'=>null,
					'日高市'=>null,
					'吉川市'=>null,
					'ふじみ野市'=>null,
					'白岡市'=>null
				],
				'千葉県'=>
				[
					'千葉市'=>
					[
						'中央区'=>null,
						'花見川区'=>null,
						'稲毛区'=>null,
						'若葉区'=>null,
						'緑区'=>null,
						'美浜区'=>null
					],
					'銚子市'=>null,
					'市川市'=>null,
					'船橋市'=>null,
					'館山市'=>null,
					'木更津市'=>null,
					'松戸市'=>null,
					'野田市'=>null,
					'茂原市'=>null,
					'成田市'=>null,
					'佐倉市'=>null,
					'東金市'=>null,
					'旭市'=>null,
					'習志野市'=>null,
					'柏市'=>null,
					'勝浦市'=>null,
					'市原市'=>null,
					'流山市'=>null,
					'八千代市'=>null,
					'我孫子市'=>null,
					'鴨川市'=>null,
					'鎌ケ谷市'=>null,
					'君津市'=>null,
					'富津市'=>null,
					'浦安市'=>null,
					'四街道市'=>null,
					'袖ケ浦市'=>null,
					'八街市'=>null,
					'印西市'=>null,
					'白井市'=>null,
					'富里市'=>null,
					'南房総市'=>null,
					'匝瑳市'=>null,
					'香取市'=>null,
					'山武市'=>null,
					'いすみ市'=>null,
					'大網白里市'=>null
				],
				'東京都'=>
				[
					'千代田区'=>null,
					'中央区'=>null,
					'港区'=>null,
					'新宿区'=>null,
					'文京区'=>null,
					'台東区'=>null,
					'墨田区'=>null,
					'江東区'=>null,
					'品川区'=>null,
					'目黒区'=>null,
					'大田区'=>null,
					'世田谷区'=>null,
					'渋谷区'=>null,
					'中野区'=>null,
					'杉並区'=>null,
					'豊島区'=>null,
					'北区'=>null,
					'荒川区'=>null,
					'板橋区'=>null,
					'練馬区'=>null,
					'足立区'=>null,
					'葛飾区'=>null,
					'江戸川区'=>null,
					'八王子市'=>null,
					'立川市'=>null,
					'武蔵野市'=>null,
					'三鷹市'=>null,
					'青梅市'=>null,
					'府中市'=>null,
					'昭島市'=>null,
					'調布市'=>null,
					'町田市'=>null,
					'小金井市'=>null,
					'小平市'=>null,
					'日野市'=>null,
					'東村山市'=>null,
					'国分寺市'=>null,
					'国立市'=>null,
					'福生市'=>null,
					'狛江市'=>null,
					'東大和市'=>null,
					'清瀬市'=>null,
					'東久留米市'=>null,
					'武蔵村山市'=>null,
					'多摩市'=>null,
					'稲城市'=>null,
					'羽村市'=>null,
					'あきる野市'=>null,
					'西東京市'=>null
				],
				'神奈川県'=>
				[
					'横浜市'=>
					[
						'鶴見区'=>null,
						'神奈川区'=>null,
						'西区'=>null,
						'中区'=>null,
						'南区'=>null,
						'保土ケ谷区'=>null,
						'磯子区'=>null,
						'金沢区'=>null,
						'港北区'=>null,
						'戸塚区'=>null,
						'港南区'=>null,
						'旭区'=>null,
						'緑区'=>null,
						'瀬谷区'=>null,
						'栄区'=>null,
						'泉区'=>null,
						'青葉区'=>null,
						'都筑区'=>null
					],
					'川崎市'=>
					[
						'川崎区'=>null,
						'幸区'=>null,
						'中原区'=>null,
						'高津区'=>null,
						'多摩区'=>null,
						'宮前区'=>null,
						'麻生区'=>null
					],
					'相模原市'=>
					[
						'緑区'=>null,
						'中央区'=>null,
						'南区'=>null
					],
					'横須賀市'=>null,
					'平塚市'=>null,
					'鎌倉市'=>null,
					'藤沢市'=>null,
					'小田原市'=>null,
					'茅ヶ崎市'=>null,
					'逗子市'=>null,
					'三浦市'=>null,
					'秦野市'=>null,
					'厚木市'=>null,
					'大和市'=>null,
					'伊勢原市'=>null,
					'海老名市'=>null,
					'座間市'=>null,
					'南足柄市'=>null,
					'綾瀬市'=>null
				]
			],
			'中部'=>
			[
				'新潟県'=>
				[
					'新潟市'=>
					[
						'北区'=>null,
						'東区'=>null,
						'中央区'=>null,
						'江南区'=>null,
						'秋葉区'=>null,
						'南区'=>null,
						'西区'=>null,
						'西蒲区'=>null
					],
					'長岡市'=>null,
					'三条市'=>null,
					'柏崎市'=>null,
					'新発田市'=>null,
					'小千谷市'=>null,
					'加茂市'=>null,
					'十日町市'=>null,
					'見附市'=>null,
					'村上市'=>null,
					'燕市'=>null,
					'糸魚川市'=>null,
					'妙高市'=>null,
					'五泉市'=>null,
					'上越市'=>null,
					'阿賀野市'=>null,
					'佐渡市'=>null,
					'魚沼市'=>null,
					'南魚沼市'=>null,
					'胎内市'=>null
				],
				'富山県'=>
				[
					'富山市'=>null,
					'高岡市'=>null,
					'魚津市'=>null,
					'氷見市'=>null,
					'滑川市'=>null,
					'黒部市'=>null,
					'砺波市'=>null,
					'小矢部市'=>null,
					'南砺市'=>null,
					'射水市'=>null
				],
				'石川県'=>
				[
					'金沢市'=>null,
					'七尾市'=>null,
					'小松市'=>null,
					'輪島市'=>null,
					'珠洲市'=>null,
					'加賀市'=>null,
					'羽咋市'=>null,
					'かほく市'=>null,
					'白山市'=>null,
					'能美市'=>null,
					'野々市市'=>null
				],
				'福井県'=>
				[
					'福井市'=>null,
					'敦賀市'=>null,
					'小浜市'=>null,
					'大野市'=>null,
					'勝山市'=>null,
					'鯖江市'=>null,
					'あわら市'=>null,
					'越前市'=>null,
					'坂井市'=>null
				],
				'山梨県'=>
				[
					'甲府市'=>null,
					'富士吉田市'=>null,
					'都留市'=>null,
					'山梨市'=>null,
					'大月市'=>null,
					'韮崎市'=>null,
					'南アルプス市'=>null,
					'北杜市'=>null,
					'甲斐市'=>null,
					'笛吹市'=>null,
					'上野原市'=>null,
					'甲州市'=>null,
					'中央市'=>null
				],
				'長野県'=>
				[
					'長野市'=>null,
					'松本市'=>null,
					'上田市'=>null,
					'岡谷市'=>null,
					'飯田市'=>null,
					'諏訪市'=>null,
					'須坂市'=>null,
					'小諸市'=>null,
					'伊那市'=>null,
					'駒ヶ根市'=>null,
					'中野市'=>null,
					'大町市'=>null,
					'飯山市'=>null,
					'茅野市'=>null,
					'塩尻市'=>null,
					'佐久市'=>null,
					'千曲市'=>null,
					'東御市'=>null,
					'安曇野市'=>null
				],
				'岐阜県'=>
				[
					'岐阜市'=>null,
					'大垣市'=>null,
					'高山市'=>null,
					'多治見市'=>null,
					'関市'=>null,
					'中津川市'=>null,
					'美濃市'=>null,
					'瑞浪市'=>null,
					'羽島市'=>null,
					'恵那市'=>null,
					'美濃加茂市'=>null,
					'土岐市'=>null,
					'各務原市'=>null,
					'可児市'=>null,
					'山県市'=>null,
					'瑞穂市'=>null,
					'飛騨市'=>null,
					'本巣市'=>null,
					'郡上市'=>null,
					'下呂市'=>null,
					'海津市'=>null
				],
				'静岡県'=>
				[
					'静岡市'=>
					[
						'葵区'=>null,
						'駿河区'=>null,
						'清水区'=>null
					],
					'浜松市'=>
					[
						'中区'=>null,
						'東区'=>null,
						'西区'=>null,
						'南区'=>null,
						'北区'=>null,
						'浜北区'=>null,
						'天竜区'=>null
					],
					'沼津市'=>null,
					'熱海市'=>null,
					'三島市'=>null,
					'富士宮市'=>null,
					'伊東市'=>null,
					'島田市'=>null,
					'富士市'=>null,
					'磐田市'=>null,
					'焼津市'=>null,
					'掛川市'=>null,
					'藤枝市'=>null,
					'御殿場市'=>null,
					'袋井市'=>null,
					'下田市'=>null,
					'裾野市'=>null,
					'湖西市'=>null,
					'伊豆市'=>null,
					'御前崎市'=>null,
					'菊川市'=>null,
					'伊豆の国市'=>null,
					'牧之原市'=>null
				],
				'愛知県'=>
				[
					'名古屋市'=>
					[
						'千種区'=>null,
						'東区'=>null,
						'北区'=>null,
						'西区'=>null,
						'中村区'=>null,
						'中区'=>null,
						'昭和区'=>null,
						'瑞穂区'=>null,
						'熱田区'=>null,
						'中川区'=>null,
						'港区'=>null,
						'南区'=>null,
						'守山区'=>null,
						'緑区'=>null,
						'名東区'=>null,
						'天白区'=>null
					],
					'豊橋市'=>null,
					'岡崎市'=>null,
					'一宮市'=>null,
					'瀬戸市'=>null,
					'半田市'=>null,
					'春日井市'=>null,
					'豊川市'=>null,
					'津島市'=>null,
					'碧南市'=>null,
					'刈谷市'=>null,
					'豊田市'=>null,
					'安城市'=>null,
					'西尾市'=>null,
					'蒲郡市'=>null,
					'犬山市'=>null,
					'常滑市'=>null,
					'江南市'=>null,
					'小牧市'=>null,
					'稲沢市'=>null,
					'新城市'=>null,
					'東海市'=>null,
					'大府市'=>null,
					'知多市'=>null,
					'知立市'=>null,
					'尾張旭市'=>null,
					'高浜市'=>null,
					'岩倉市'=>null,
					'豊明市'=>null,
					'日進市'=>null,
					'田原市'=>null,
					'愛西市'=>null,
					'清須市'=>null,
					'北名古屋市'=>null,
					'弥富市'=>null,
					'みよし市'=>null,
					'あま市'=>null,
					'長久手市'=>null
				]
			],
			'近畿'=>
			[
				'三重県'=>
				[
					'津市'=>null,
					'四日市市'=>null,
					'伊勢市'=>null,
					'松阪市'=>null,
					'桑名市'=>null,
					'鈴鹿市'=>null,
					'名張市'=>null,
					'尾鷲市'=>null,
					'亀山市'=>null,
					'鳥羽市'=>null,
					'熊野市'=>null,
					'いなべ市'=>null,
					'志摩市'=>null,
					'伊賀市'=>null
				],
				'滋賀県'=>
				[
					'大津市'=>null,
					'彦根市'=>null,
					'長浜市'=>null,
					'近江八幡市'=>null,
					'草津市'=>null,
					'守山市'=>null,
					'栗東市'=>null,
					'甲賀市'=>null,
					'野洲市'=>null,
					'湖南市'=>null,
					'高島市'=>null,
					'東近江市'=>null,
					'米原市'=>null
				],
				'京都府'=>
				[
					'京都市'=>
					[
						'北区'=>null,
						'上京区'=>null,
						'左京区'=>null,
						'中京区'=>null,
						'東山区'=>null,
						'下京区'=>null,
						'南区'=>null,
						'右京区'=>null,
						'伏見区'=>null,
						'山科区'=>null,
						'西京区'=>null
					],
					'福知山市'=>null,
					'舞鶴市'=>null,
					'綾部市'=>null,
					'宇治市'=>null,
					'宮津市'=>null,
					'亀岡市'=>null,
					'城陽市'=>null,
					'向日市'=>null,
					'長岡京市'=>null,
					'八幡市'=>null,
					'京田辺市'=>null,
					'京丹後市'=>null,
					'南丹市'=>null,
					'木津川市'=>null
				],
				'大阪府'=>
				[
					'大阪市'=>
					[
						'都島区'=>null,
						'福島区'=>null,
						'此花区'=>null,
						'西区'=>null,
						'港区'=>null,
						'大正区'=>null,
						'天王寺区'=>null,
						'浪速区'=>null,
						'西淀川区'=>null,
						'東淀川区'=>null,
						'東成区'=>null,
						'生野区'=>null,
						'旭区'=>null,
						'城東区'=>null,
						'阿倍野区'=>null,
						'住吉区'=>null,
						'東住吉区'=>null,
						'西成区'=>null,
						'淀川区'=>null,
						'鶴見区'=>null,
						'住之江区'=>null,
						'平野区'=>null,
						'北区'=>null,
						'中央区'=>null
					],
					'堺市'=>
					[
						'堺区'=>null,
						'中区'=>null,
						'東区'=>null,
						'西区'=>null,
						'南区'=>null,
						'北区'=>null,
						'美原区'=>null
					],
					'岸和田市'=>null,
					'豊中市'=>null,
					'池田市'=>null,
					'吹田市'=>null,
					'泉大津市'=>null,
					'高槻市'=>null,
					'貝塚市'=>null,
					'守口市'=>null,
					'枚方市'=>null,
					'茨木市'=>null,
					'八尾市'=>null,
					'泉佐野市'=>null,
					'富田林市'=>null,
					'寝屋川市'=>null,
					'河内長野市'=>null,
					'松原市'=>null,
					'大東市'=>null,
					'和泉市'=>null,
					'箕面市'=>null,
					'柏原市'=>null,
					'羽曳野市'=>null,
					'門真市'=>null,
					'摂津市'=>null,
					'高石市'=>null,
					'藤井寺市'=>null,
					'東大阪市'=>null,
					'泉南市'=>null,
					'四條畷市'=>null,
					'交野市'=>null,
					'大阪狭山市'=>null,
					'阪南市'=>null
				],
				'兵庫県'=>
				[
					'神戸市'=>
					[
						'東灘区'=>null,
						'灘区'=>null,
						'兵庫区'=>null,
						'長田区'=>null,
						'須磨区'=>null,
						'垂水区'=>null,
						'北区'=>null,
						'中央区'=>null,
						'西区'=>null
					],
					'姫路市'=>null,
					'尼崎市'=>null,
					'明石市'=>null,
					'西宮市'=>null,
					'洲本市'=>null,
					'芦屋市'=>null,
					'伊丹市'=>null,
					'相生市'=>null,
					'豊岡市'=>null,
					'加古川市'=>null,
					'赤穂市'=>null,
					'西脇市'=>null,
					'宝塚市'=>null,
					'三木市'=>null,
					'高砂市'=>null,
					'川西市'=>null,
					'小野市'=>null,
					'三田市'=>null,
					'加西市'=>null,
					'丹波篠山市'=>null,
					'養父市'=>null,
					'丹波市'=>null,
					'南あわじ市'=>null,
					'朝来市'=>null,
					'淡路市'=>null,
					'宍粟市'=>null,
					'加東市'=>null,
					'たつの市'=>null
				],
				'奈良県'=>
				[
					'奈良市'=>null,
					'大和高田市'=>null,
					'大和郡山市'=>null,
					'天理市'=>null,
					'橿原市'=>null,
					'桜井市'=>null,
					'五條市'=>null,
					'御所市'=>null,
					'生駒市'=>null,
					'香芝市'=>null,
					'葛城市'=>null,
					'宇陀市'=>null
				],
				'和歌山県'=>
				[
					'和歌山市'=>null,
					'海南市'=>null,
					'橋本市'=>null,
					'有田市'=>null,
					'御坊市'=>null,
					'田辺市'=>null,
					'新宮市'=>null,
					'紀の川市'=>null,
					'岩出市'=>null
				]
			],
			'中国・四国'=>
			[
				'鳥取県'=>
				[
					'鳥取市'=>null,
					'米子市'=>null,
					'倉吉市'=>null,
					'境港市'=>null
				],
				'島根県'=>
				[
					'松江市'=>null,
					'浜田市'=>null,
					'出雲市'=>null,
					'益田市'=>null,
					'大田市'=>null,
					'安来市'=>null,
					'江津市'=>null,
					'雲南市'=>null
				],
				'岡山県'=>
				[
					'岡山市'=>
					[
						'北区'=>null,
						'中区'=>null,
						'東区'=>null,
						'南区'=>null
					],
					'倉敷市'=>null,
					'津山市'=>null,
					'玉野市'=>null,
					'笠岡市'=>null,
					'井原市'=>null,
					'総社市'=>null,
					'高梁市'=>null,
					'新見市'=>null,
					'備前市'=>null,
					'瀬戸内市'=>null,
					'赤磐市'=>null,
					'真庭市'=>null,
					'美作市'=>null,
					'浅口市'=>null
				],
				'広島県'=>
				[
					'広島市'=>
					[
						'中区'=>null,
						'東区'=>null,
						'南区'=>null,
						'西区'=>null,
						'安佐南区'=>null,
						'安佐北区'=>null,
						'安芸区'=>null,
						'佐伯区'=>null
					],
					'呉市'=>null,
					'竹原市'=>null,
					'三原市'=>null,
					'尾道市'=>null,
					'福山市'=>null,
					'府中市'=>null,
					'三次市'=>null,
					'庄原市'=>null,
					'大竹市'=>null,
					'東広島市'=>null,
					'廿日市市'=>null,
					'安芸高田市'=>null,
					'江田島市'=>null
				],
				'山口県'=>
				[
					'下関市'=>null,
					'宇部市'=>null,
					'山口市'=>null,
					'萩市'=>null,
					'防府市'=>null,
					'下松市'=>null,
					'岩国市'=>null,
					'光市'=>null,
					'長門市'=>null,
					'柳井市'=>null,
					'美祢市'=>null,
					'周南市'=>null,
					'山陽小野田市'=>null
				],
				'徳島県'=>
				[
					'徳島市'=>null,
					'鳴門市'=>null,
					'小松島市'=>null,
					'阿南市'=>null,
					'吉野川市'=>null,
					'阿波市'=>null,
					'美馬市'=>null,
					'三好市'=>null
				],
				'香川県'=>
				[
					'高松市'=>null,
					'丸亀市'=>null,
					'坂出市'=>null,
					'善通寺市'=>null,
					'観音寺市'=>null,
					'さぬき市'=>null,
					'東かがわ市'=>null,
					'三豊市'=>null
				],
				'愛媛県'=>
				[
					'松山市'=>null,
					'今治市'=>null,
					'宇和島市'=>null,
					'八幡浜市'=>null,
					'新居浜市'=>null,
					'西条市'=>null,
					'大洲市'=>null,
					'伊予市'=>null,
					'四国中央市'=>null,
					'西予市'=>null,
					'東温市'=>null
				],
				'高知県'=>
				[
					'高知市'=>null,
					'室戸市'=>null,
					'安芸市'=>null,
					'南国市'=>null,
					'土佐市'=>null,
					'須崎市'=>null,
					'宿毛市'=>null,
					'土佐清水市'=>null,
					'四万十市'=>null,
					'香南市'=>null,
					'香美市'=>null
				]
			],
			'九州・沖縄'=>
			[
				'福岡県'=>
				[
					'北九州市'=>
					[
						'門司区'=>null,
						'若松区'=>null,
						'戸畑区'=>null,
						'小倉北区'=>null,
						'小倉南区'=>null,
						'八幡東区'=>null,
						'八幡西区'=>null
					],
					'福岡市'=>
					[
						'東区'=>null,
						'博多区'=>null,
						'中央区'=>null,
						'南区'=>null,
						'西区'=>null,
						'城南区'=>null,
						'早良区'=>null
					],
					'大牟田市'=>null,
					'久留米市'=>null,
					'直方市'=>null,
					'飯塚市'=>null,
					'田川市'=>null,
					'柳川市'=>null,
					'八女市'=>null,
					'筑後市'=>null,
					'大川市'=>null,
					'行橋市'=>null,
					'豊前市'=>null,
					'中間市'=>null,
					'小郡市'=>null,
					'筑紫野市'=>null,
					'春日市'=>null,
					'大野城市'=>null,
					'宗像市'=>null,
					'太宰府市'=>null,
					'古賀市'=>null,
					'福津市'=>null,
					'うきは市'=>null,
					'宮若市'=>null,
					'嘉麻市'=>null,
					'朝倉市'=>null,
					'みやま市'=>null,
					'糸島市'=>null,
					'那珂川市'=>null
				],
				'佐賀県'=>
				[
					'佐賀市'=>null,
					'唐津市'=>null,
					'鳥栖市'=>null,
					'多久市'=>null,
					'伊万里市'=>null,
					'武雄市'=>null,
					'鹿島市'=>null,
					'小城市'=>null,
					'嬉野市'=>null,
					'神埼市'=>null
				],
				'長崎県'=>
				[
					'長崎市'=>null,
					'佐世保市'=>null,
					'島原市'=>null,
					'諫早市'=>null,
					'大村市'=>null,
					'平戸市'=>null,
					'松浦市'=>null,
					'対馬市'=>null,
					'壱岐市'=>null,
					'五島市'=>null,
					'西海市'=>null,
					'雲仙市'=>null,
					'南島原市'=>null
				],
				'熊本県'=>
				[
					'熊本市'=>
					[
						'中央区'=>null,
						'東区'=>null,
						'西区'=>null,
						'南区'=>null,
						'北区'=>null
					],
					'八代市'=>null,
					'人吉市'=>null,
					'荒尾市'=>null,
					'水俣市'=>null,
					'玉名市'=>null,
					'山鹿市'=>null,
					'菊池市'=>null,
					'宇土市'=>null,
					'上天草市'=>null,
					'宇城市'=>null,
					'阿蘇市'=>null,
					'天草市'=>null,
					'合志市'=>null
				],
				'大分県'=>
				[
					'大分市'=>null,
					'別府市'=>null,
					'中津市'=>null,
					'日田市'=>null,
					'佐伯市'=>null,
					'臼杵市'=>null,
					'津久見市'=>null,
					'竹田市'=>null,
					'豊後高田市'=>null,
					'杵築市'=>null,
					'宇佐市'=>null,
					'豊後大野市'=>null,
					'由布市'=>null,
					'国東市'=>null
				],
				'宮崎県'=>
				[
					'宮崎市'=>null,
					'都城市'=>null,
					'延岡市'=>null,
					'日南市'=>null,
					'小林市'=>null,
					'日向市'=>null,
					'串間市'=>null,
					'西都市'=>null,
					'えびの市'=>null
				],
				'鹿児島県'=>
				[
					'鹿児島市'=>null,
					'鹿屋市'=>null,
					'枕崎市'=>null,
					'阿久根市'=>null,
					'出水市'=>null,
					'指宿市'=>null,
					'西之表市'=>null,
					'垂水市'=>null,
					'薩摩川内市'=>null,
					'日置市'=>null,
					'曽於市'=>null,
					'霧島市'=>null,
					'いちき串木野市'=>null,
					'南さつま市'=>null,
					'志布志市'=>null,
					'奄美市'=>null,
					'南九州市'=>null,
					'伊佐市'=>null,
					'姶良市'=>null
				],
				'沖縄県'=>
				[
					'那覇市'=>null,
					'宜野湾市'=>null,
					'石垣市'=>null,
					'浦添市'=>null,
					'名護市'=>null,
					'糸満市'=>null,
					'沖縄市'=>null,
					'豊見城市'=>null,
					'うるま市'=>null,
					'宮古島市'=>null,
					'南城市'=>null
				]
			]
		];

		return($address_data);
	}

	function get_address_list()
	{
		$array = address_list();
		$return_txt = json_encode($array);
		echo $return_txt;
	}

	function buffer_file($txt)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		$length = 10;
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

        $file_name = $randomString;

		$myfile = fopen($file_name, "w") or die("Unable to open file!");
		fwrite($myfile, $txt);
		fclose($myfile);

		return $file_name;
	}

	function save_data()
	{
		$src     = $_POST['src'];
		$color   = $_POST['color'];
		$tnr     = $_POST['tnr'];
		$gps     = $_POST['gps'];
		$user_id = $_POST['user_id'];
		$is_first= $_POST['is_first'];
		$cat_id = null;
		$ispass = 'true';
		if($_POST['is_first']=='false')
		{
			$cat_id = $_POST['cat_id'];
		}

		if(isset($_POST['is_pass']))
		{
			$ispass = $_POST['is_pass'];
		}

		if($_POST['checker']=='null')
        {
            $ispass='false';
        }

		exec('python dogeopy.py {\"lat\":'.$gps['0'].',\"lng\":'.$gps['1'].'}',$testoutput);
		$file_name = buffer_file($src);
		exec('python resizebase.py '.$file_name ,$resizebase);

		$fu  = json_decode($testoutput[0])->{'fu'};
		$fu  = base64_decode(str_replace(["b'","'"],"",$fu));
		$shi = json_decode($testoutput[0])->{'shi'};
		$shi = base64_decode(str_replace(["b'","'"],"",$shi));
		$ku  = json_decode($testoutput[0])->{'ku'};
		$ku  = base64_decode(str_replace(["b'","'"],"",$ku));
		$lat = $gps['0'];
		$lng = $gps['1'];

		//$return_txt = json_encode(
		//	array(
		//		'src'     => $resizebase,
		//		'color'   => $color,
		//		'tnr'     => $tnr,
		//		'lat'     => $gps['0'],
		//		'lng'     => $gps['1'],
		//		'user_id' => $user_id,
		//		'fu'      => $fu,
		//		'shi'     => $shi,
		//		'ku'      => $ku
		//		)
		//);

		$cat_oid = add_cat_data( $resizebase[0], $color, $tnr, $lat, $lng, $fu, $shi, $ku, $user_id, $is_first,$cat_id,$ispass);
		$return_txt = json_encode(
			$cat_oid
		);
		$return_txt = substr($return_txt,0,-1).',"func":"save"}';
		echo  $return_txt;
	}

	function gat_img_array()
	{
		$user_id = $_POST['user_id'];

		$return_txt = json_encode(
			array(
				'user_id' => $user_id
				)
		);

		$cat_id = get_CatArray_form_UserId($user_id);

		$return_txt = json_encode(
			$cat_id
		);

		echo $return_txt;

	}

	function get_some_cat_array()
	{
		$color   = $_POST['color'];
		$gps     = $_POST['gps'];

		exec('python get_GpsLimit.py {\"lat\":'.$gps['0'].',\"lng\":'.$gps['1'].'}',$limitoutput);

		$data = json_decode($limitoutput[0]);
		$lat_min = $data -> {'lat_min'};
		$lat_max = $data -> {'lat_max'};
		$lng_min = $data -> {'lng_min'};
		$lng_max = $data -> {'lng_max'};

		$return_data = search_some_cat($color,$lat_min,$lat_max, $lng_min, $lng_max);

		if(empty($return_data))
		{
			save_data();
			return(1);
		}
		//echo json_encode(['test'=>'isok']);
		//exit();
		$return_txt = json_encode(
			$return_data
		);

		echo $return_txt;
	}

	function CatId_get_cat_array()
	{
		$cat_id = $_POST['cat_id'];

		$return_data = CatId_get_array($cat_id);

		$return_txt = json_encode(
			$return_data
		);

		echo $return_txt;
	}

	function add_new_user()
	{
		$user_name = $_POST['name'];
		$user_email = $_POST['email'];
		$user_pwd = $_POST['pwd'];

		$user_id = add_user($user_email,$user_pwd,$user_name);

		$return_txt = json_encode(
			$user_id
		);

		echo $return_txt;
	}

	function search_user()
	{
		$key = $_POST['key'];
		$_id = $_POST['user_id'];
		$output_id_and_name = search_userName($key);
		$output_rootLevel = Id_get_rootLevel($_id);
		
		$return_txt1 = json_encode(
			$output_id_and_name
		);	

		$return_txt2 = json_encode(
			$output_rootLevel
		);

		$return_txt = substr($return_txt1,0,-2).','.substr($return_txt2,2);

		echo $return_txt;
	}

	function id_gat_img()
	{
		$cat_id = $_POST['cat_id'];

		$user_id = IdGatImg($cat_id);

		$return_txt = json_encode(
			$user_id
		);

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
			case 'get_src':return(get_src());
			case 'get_address_list':return(get_address_list());
			case 'save_data':return(save_data());
			case 'gat_img_array':return(gat_img_array());
			case 'get_some_cat_array':return(get_some_cat_array());
			case 'CatId_get_cat_array':return(CatId_get_cat_array());
			case 'add_new_user':return(add_new_user());
			case 'search_user':return(search_user());
			case 'id_gat_img':return(id_gat_img());
        }
    }
?>

