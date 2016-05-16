<html>
<head>
		<meta name="viewport" content="width=device-width,initial-scale=1.2,minimum-scale=1.0,maximum-scale=1.0" />
		<meta charset="UTF8">
		<title>PANDA VIDEO</title>

		<link rel="stylesheet" href="CSS/style.css">
		<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<!-- 합쳐지고 최소화된 최신 자바스크립트 -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<!-- 합쳐지고 최소화된 최신 CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<!-- 부가적인 테마 -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="CSS/jquery.sidr.light.css">
		<script src="jquery.sidr.min.js"></script>

		<script type="text/javascript">
			function showVideo(fileurl, vtturl)
			{
				if (fileurl.indexOf('.mkv') > 0){
					alert ('MKV 파일은 PC로 이용이 불가능 합니다. \n\n 모바일을 이용 해주세요.');
					return; }
					video = '<video width="100%" height="50%" controls autoplay>' +
					'<source src="'+fileurl+'" type="video/mp4">' +
					'<track label="Korea" kind="subtitles" srclang="ko" src="'+vtturl+'" default>' +
				'</video>';
					$(".modal-body").html(video);

					$('#myModal').modal('show');

					$('#myModal').on('hidden.bs.modal', function () {
							$(".modal-body").html('');
					});
			}
		</script>
</head>

<body>
	<div id="wrap">
	<!-- Modal -->
	<?php
		if (file_exists('HDD/Ani/'.$_GET['page'].'/main.jpg'))
			echo('<div class="pic" style="background:url(\'HDD/Ani/'.$_GET['page'].'/main.jpg\') fixed;"></div>');
	?>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
			<div class="modal-content">
				  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
						<h4 class="modal-title" id="myModalLabel">PANDA VIDEO</h4>
				  </div>
				  <div class="modal-body"></div>
				 <div class="modal-footer">
					 <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
				 </div>
			</div>
	  </div>
	</div>

	<div id="head"><?php directory_list('HDD/Ani/'); ?></div>
	<div id="body">
		<?php
				$dir = 'HDD/Ani/';
				if  ($_GET['page'] != '')
				{
					$dir = $dir.$_GET['page'].'/';
				}

				$files = scandir($dir);
				foreach($files as $ind_file=>$afile){
					if($ind_file!=0 & $ind_file!=1){
					if (substr($afile,strrpos($afile,".")) == '.mp4' || substr($afile,strrpos($afile,".")) ==  '.mkv'){
					  $url_video = rawurlencode($afile);
						$ip = gethostbyname(gethostname()).'\\';

						$frame = 10;
						$movie =  $dir. $url_video;
						$movie2 = $_GET['page'].'/'. $url_video;

						$smipath = $dir. str_replace(explode('.',$afile)[substr_count($afile,'.')],'smi',$afile);
						$vtturl = "";

						if(is_file($smipath))
							$vtturl =  './sub.php?src=./'.rawurlencode($smipath);

						$thumbnail =  'HDD/Anithumbnail/'. $afile .'.png';

						if(is_file($thumbnail )==false){
							$mov = new ffmpeg_movie($movie);
							$frame = $mov->getFrame($frame);
						if ($frame) {
							$gd_image = $frame->toGDImage();
							if ($gd_image) {
								imagepng($gd_image, $thumbnail);
								imagedestroy($gd_image);
								if (strpos($_SERVER["HTTP_USER_AGENT"], "Android") == false)
									echo "<a  href='#' onclick=\"showVideo('{$movie}', '{$vtturl}')\"> <div class='video_sub' style='background: url(".rawurlencode($thumbnail).") no-repeat; background-size: 100px 80px; background-color: e4e4e4; ' ><p>".Ani_replace($afile)."</p></div></a>";
								else
									echo "<a href=\"./redirect.php?url={$movie2}\"> <div class='video_sub' style='background: url(".rawurlencode($thumbnail).") no-repeat; background-size: 100px 80px; background-color: e4e4e4; '><p>".Ani_replace($afile)."</p></div></a>";
						}
					}} else {
							if (strpos($_SERVER["HTTP_USER_AGENT"], "Android") == false)
								echo "<a  href='#' onclick=\"showVideo('{$movie}', '{$vtturl}')\"> <div class='video_sub' style='background: url(".rawurlencode($thumbnail).") no-repeat; background-size: 100px 80px; background-color: e4e4e4; ' ><p>".Ani_replace($afile)."</p></div></a>";
							else
								echo "<a href=\"./redirect.php?url={$movie2}\"> <div class='video_sub' style='background: url(".rawurlencode($thumbnail).") no-repeat; background-size: 100px 80px; background-color: e4e4e4; '><p>".Ani_replace($afile)."</p></div></a>";
					}
				}}
		}

	function Ani_replace($subject){
			$en = array("Yahari Ore no Seishun Love Come wa Machigatteiru. Zoku", "Nisekoi","Fate - Stay Night - Unlimited Blade Works (2015)","Fate - Stay Night - Unlimited Blade Works","Grisaia no Rakuen","Dungeon ni Deai o Motomeru no wa Machigatte Iru Darouka","경계의저편");
			$ko = array("내청코 ", "니세코이 ","페이트 2기 ","페이트 1기  ","낙원 ","던만추","경계의 저편");
			$zero = $subject;

			if (strpos($subject,"Leopard") == true)
				$raw = "RAW ";
			else if(strpos($subject,"Ohys") == true)
				$raw = "(";
			else
				return $subject;

			$enko = explode("]",$subject);
			$enko = explode($raw,$enko[1]);

			if (strpos(str_replace($en,$ko,$enko[0]),"(") == true)
			{
				$enko = explode("(",$enko[0]);
				return  str_replace($en,$ko,$enko[0]);
			}
			return  str_replace($en,$ko,$enko[0]);
	}

	function directory_list($dir){
		echo '<a href="./test.php" style="margin: 3 auto auto 3;" class="btn btn-info">기본폴더</a>';
		echo '<a href="./test.php?page=라이브" style="margin: 3 auto auto 3;" class="btn btn-warning">라이브</a>';
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {

					if( $file == '.' || $file == '..' || $file == '미즈키나나' || $file == '라이브' )
					 continue;

					$files[] = $file;
				}
				sort($files);
				foreach($files as $file)
					if(filetype($dir . $file) == 'dir') {
						echo '<a href="./test.php?page='.rawurlencode($file).'" style="margin: 3 auto auto 3;" class="btn btn-danger">'.$file.'</a>';
					}
				closedir($dh);
			}
		}
	}
	?>
	</div> <!-- id: body -->
	</div> <!-- id: wrap -->
	</body>
</html>
