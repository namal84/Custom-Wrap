<?php
	/**
		Author			:	Namal Balasuriya
		Date Created	:	12/10/2019
		Date Modified	:	14/10/2019
		Modified Reason	:	To work independently without the form error handling.
							To handle all errors within the function itself.
							To pass all the functional requirements.
							To make the function call secure while filtering the input values.
		Email			:	namal_nais@yahoo.com
		Version			:	1.0
		Description		:	This module is build to word wrap text block without using built-in functions.
	*/
	
	$para = "";
	$len = "";

	function clean($val)
	{
		$val = trim($val);
		$val = strip_tags($val);
		$val = stripslashes($val);
		$val = htmlspecialchars($val);
		
		return $val;
	}
	
	function wrap($string='', $length=1)
	{
		try
		{		
			if($string == '' || empty($string))
			{
				exit("Text block cannot be empty");
			}
			elseif($length == '')
			{
				exit("Please specify a length to break the text");
			}
			elseif(is_numeric($length) === false)
			{
				exit("Length must be numeric");
			}
			elseif(is_numeric($length) === true && $length <= 0)
			{
				exit("Length must be greater than zero");
			}
			else
			{
				$arrOutput = array("");
				// Splitting words based on space
				$arrWords = explode(" ", $string);
				// Removing empty values and re-indexing elements (when you have more than a space among words)
				$arrWords = array_values(array_filter($arrWords));
				$index = 0;
				$spaceCount = 1;
				if(count($arrWords) > 1)
				{
					// If there are more than one word in the text block
					$currentLength = 0;
					
					// Looping through each word to check character length 
					foreach($arrWords as $word)
					{
						$wordLength = strlen($word);
						if($wordLength > $length)
						{
							// If a specific word length exceed max length breaking it in to multiple lines
							$spaceCount = 1;
							if($wordLength > $length)
							{
								for($c=0; $c<strlen($word); $c+=$length)
								{
									$index += 1; 
									$arrOutput[$index] = substr($word, $c, $length);
									$currentLength = strlen($arrOutput[$index]);
								}
								$currentLength += 1; 
							}
						}
						elseif(($currentLength + $wordLength) < $length)
						{
							// Concatinating words until reach the max length
							$currentLength += ($wordLength + $spaceCount);
							$spaceCount++;
							$arrOutput[$index] .= ($word . " ");
						}
						else
						{
							// Handling the words under the max length
							$spaceCount = 1;
							$index += 1;
							$currentLength = $wordLength;
							$arrOutput[$index] = ($word . " ");
						}
					}
				}
				else
				{
					// If there is only one word or character stream
					$wordLength = strlen($string);
					if($wordLength > $length)
					{
						for($c=0; $c<strlen($string); $c+=$length)
						{
							$arrOutput[$index++] = substr($string, $c, $length);
						}
					}
					else
					{
						$arrOutput[$index++] = substr($string, 0, $length);
					}
				}
				
				// Removing all whitespaces before sending the output
				$arrOutput = array_map('trim', $arrOutput);
				
				$string = implode("\n", $arrOutput);
				return $string;
			}
		}
		catch(Exception $e)
		{
			// Developer message
			// echo $e->getMessage();
			echo "Unexpected error occurred";
		}
	}

	$tc = 7;
	switch($tc)
	{
		case 1:
				$para = "Namal Balasuriya";
				$len = 1;
				break;
		case 2:
				$para = "PHP custom word wrap function";
				$len = 2;
				break;
		case 3:
				$para = "PHP custom word wrap function";
				$len = 3;
				break;
		case 4:
				$para = "This is a sample text content";
				$len = 4;
				break;
		case 5:
				$para = "This is a sample text content";
				$len = 5;
				break;
		case 6:
				$para = "test   testing";
				$len = 4;
				break;
		case 7:
				$para = "<p>test   testing</p>";
				$len = 4;
				break;
		default:
				$para = "";
				$len = 0;
	}

	// Cleaning the input values before executing the function
	$para = clean($para);
	$len = clean($len);
	
	// Displaying the original text block...
	echo "<b>Text Block:</b> " . (($para == '') ? '-' : $para);
	echo "<br /><br />";
	echo "<b>Wrapped By:</b> " . (($len == '') ? '-' : $len . " character(s)");
	echo "<br /><br />";
	
	// Calling the function and returning the output
	echo "<b>Output</b>";
	echo "<br />";
	
	echo "<pre>" . wrap($para, $len) . "</pre>";
?>