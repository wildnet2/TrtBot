
										<?php
										ini_set('display_errors', 1);
										ini_set('display_startup_errors', 1);
										error_reporting(E_ALL);

										$botoken="363588295:AAHNYXjWEgri5ZPIfNPlUbq0VQHoDFV-rik";
										$website="https://api.telegram.org/bot".$botoken;

										$update = file_get_contents('php://input');
										$update = json_decode($update,TRUE);

										$chatId = $update["message"]["chat"]["id"];
										$message = $update["message"]["text"];
										$telegramUsername = $update['message']['from']['username'];
										$messageId = $update['message']['message_id'];
										$message_name = $update['message']['chat']['first_name'];

										if (strpos(urlencode($message), '/profit') !== false) {
										    
										    $cose = urlencode($message);
										}
										switch($message){								
												case '/askbid':
													askBid($chatId);
														break;
												case '/profit':
													profit($chatId,$message,$cose); 
													break;
												case '/ticker':
													ticker($chatId);
													break;

												case '/askbid@trtPocketBot':
													askBid($chatId);
														break;

												case '/ticker@trtPocketBot':
													ticker($chatId);
														break;
												default:
													functionDiBenvenuto($chatId);
													break;
											}
									/////////////////////////////////////////////////////////////////////////////////////		
											function inviaMessaggio($chatId,$message){
												$url="$GLOBALS[website]/sendMessage?chat_id=$chatId&text=$message";
												file_get_contents($url);
											}
									/////////////////////////////////////////////////////////////////////////////////////
											function profit($chatId,$message,$cose){
												
								
														$messaggio = "Il comando profit non è ancora stato implementato. Puppa (for dont forget)";
														inviaMessaggio($chatId,$messaggio);
													//}	
											}
									/////////////////////////////////////////////////////////////////////////////////////
											function functionDiBenvenuto($chatId){
												$messaggio = 'Lancia un comando perchè trtPocketBot ti risponda!';
												inviaMessaggio($chatId,$messaggio);
											}

									/////////////////////////////////////////////////////////////////////////////////////
											function askBid($chatId){
																			//conf url per chiamata get
										$url = "https://api.therocktrading.com/v1/funds/BTCEUR/orderbook";
										
										$headers = array(
												"Content-Type: application/json"
												);
										//chiamata al server
										$ch = curl_init();
										curl_setopt($ch, CURLOPT_URL, $url);
										curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										$callResult = curl_exec($ch);
										curl_close($ch);
										
										//decodifico risultato della chiamata in json
										$result = json_decode($callResult, true);

										//ciclo ogni elemento nel json delle asks e ne estraggo i valori
										$elementCount  = count($result['asks']);
					
											  $message1 = urlencode("Ask:\nprice:".$result['asks'][0]['price']);
											  $message2 = urlencode("\namount:".$result['asks'][0]['amount']);
											  $message3 = urlencode("\ndepth:".$result['asks'][0]['depth']);
											  		inviaMessaggio($chatId,$message1.$message2.$message3);
																			
										//ciclo ogni elemento del json bids e ne estraggo i valori
										//$elementCountBids  = count($result['bids']);
			
							
											  $message4 = urlencode("Bid:\nprice:".$result['bids'][0]['price']);
											  $message5 = urlencode("\namount:".$result['bids'][0]['amount']);
											  $message6 = urlencode("\ndepth:".$result['bids'][0]['depth']);
													inviaMessaggio($chatId,$message4.$message5.$message6);
											
										}
										/////////////////////////////////////////////////////////////////////////////////////

										function ticker($chatId){
												$fund_id="BTCEUR";

												$url="https://api.therocktrading.com/v1/funds/".$fund_id."/ticker";

												$headers=array(
												  "Content-Type: application/json"
												);

												$ch=curl_init();
												curl_setopt($ch,CURLOPT_URL,$url);
												curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
												curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
												$callResult=curl_exec($ch);
												curl_close($ch);

												$result=json_decode($callResult,true);

												$message = urlencode(
													"Last trade:\nExchange:"
													.$result['fund_id']
													."\nVolume:"
													.$result["volume_traded"]
													."\nValue:"
													.$result['last']);
												inviaMessaggio($chatId,$message);
										}

									    ////////////////////////////////////////////////////////////////////////////////////
										?>

			
					
