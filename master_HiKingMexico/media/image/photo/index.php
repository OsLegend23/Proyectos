<?php
include('../../../inc/common.inc.php');
include('../../../inc/SimpleImage.php');

/*
	../media/image/photo/index.php?encript&location=company&link=linkPhotoCompany&init=519&finish=519
*/

if(isset($_REQUEST['encript']))
{	
		$location 		= $_REQUEST['location'].'/';
		$link 			= $GLOBAL[$_REQUEST['link']];

		$account_init 	= $_REQUEST['init'];
		$account_finish = $_REQUEST['finish'];

		for ($i=$account_init; $i <= $account_finish; $i++) { 	
				
				$folder = $location.$i;

						if(file_exists($folder))
						{
							echo "======================= $folder =======================<br>";

							$handle=opendir($folder);
							while (($file = readdir($handle))!==false) 
							{
									//$eImage = new SimpleImage();
								    //$eImage->load($newname);						    
								    //$eImage->save($newname_50p);
									$extension = getExtension($file);

									

									if($extension != false && $file != "index.php")
									{

										$image_name =  null;
										
										switch ($_REQUEST['link']) 
										{
										case 'linkPhotoPostulant':
												if(strrpos($file, '_50p') !== false)
												{
													$image_name=md5($i.$GLOBAL['token']).'_50p.'.$extension;
												}
												else
												if(strrpos($file, '_30p') !== false)
												{
													$image_name=md5($i.$GLOBAL['token']).'_30p.'.$extension;
												}
												else
												if(strcmp($file, $i.'.'.$extension) == 0)
												{
													$image_name=md5($i.$GLOBAL['token']).'.'.$extension;	
												}
												else
												if(strcmp($file, md5($i.$GLOBAL['token']).'.'.$extension) == 0)
												{
													$image_name=md5($i.$GLOBAL['token']).'.'.$extension;		
												}		
											break;
										case 'linkPhotoCompany':
																	
												if(strrpos($file, '_30p') !== false)
												{
													$image_name=md5($i.$GLOBAL['token']).'_30p.'.$extension;
												}
												else
												if(strrpos($file, '_50p') !== false)
												{
													$image_name=md5($i.$GLOBAL['token']).'_50p.'.$extension;
												}
												else
												if(strcmp($file, $i.'.'.$extension) == 0)
												{
													$image_name=md5($i.$GLOBAL['token']).'.'.$extension;	
												}
												else
												if(strcmp($file, md5($i.$GLOBAL['token']).'.'.$extension) == 0)
												{
													$image_name=md5($i.$GLOBAL['token']).'.'.$extension;		
												}
											break;
										
										default:
											
											break;
										}


										echo $file.' -- '.$image_name.'<br>';

										if(isset($image_name))
										{										
											$file = $COMMON->findFile($file, $link.$i.'/');
											//getMedia($link.$i, $file);
											$fileImage = $COMMON->getRoot().$link.$i.'/'.$image_name;
											rename($file, $fileImage);
										}
										else
										{
											echo $file.' Imagen no se pudo cambiar '.'<br>';
										}
									}
								    
							
							}
							closedir($handle);									
						}
		}
}
		function getExtension($str) {
			$i = strrpos($str,".");
			if (!$i) { return false; }
			$l = strlen($str) - $i;
			$ext = substr($str,$i+1,$l);
			return $ext;
	    }

?>
<h2>
	<?php echo $GLOBALS_STR['strAccessDenied'];?>
</h2>