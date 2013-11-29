<?php

function int32($n) {
    while ($n >= 2147483648) $n -= 4294967296;
    while ($n <= -2147483649) $n += 4294967296;
    return (int)$n;
}

/*
| ---------------------------
| Class stringchange
| ---------------------------
*/

class stringchange {

    function shr32($x, $bits){   
        // Î»ÒÆÁ¿³¬³ö·¶Î§µÄÁ½ÖÖÇé¿ö   
        if($bits <= 0) {   
            return $x;   
        }   
        if($bits >= 32) {   
            return 0;   
        }   
        //×ª»»³É´ú±í¶þ½øÖÆÊý×ÖµÄ×Ö·û´®   
        $bin = decbin($x);   
        $l = strlen($bin);   
        //×Ö·û´®³¤¶È³¬³öÔò½ØÈ¡µ×32Î»£¬³¤¶È²»¹»£¬ÔòÌî³ä¸ßÎ»Îª0µ½32Î»   
        if($l > 32) {   
            $bin = substr($bin, $l - 32, 32);   
        }elseif($l < 32){   
            $bin = str_pad($bin, 32, '0', STR_PAD_LEFT);   
        }   
        //È¡³öÒªÒÆ¶¯µÄÎ»Êý£¬²¢ÔÚ×ó±ßÌî³ä0   
        return bindec(str_pad(substr($bin, 0, 32 - $bits), 32, '0', STR_PAD_LEFT));   
    } 

    function byteArrayToShort($b) {
        return ($b[0] << 8) + ($b[1] & 0xFF);
    }

    function byteArrayToInt($b) {
 						               
 		return int32(($b[0] << 24)) + (($b[1] & 0xFF) << 16) + (($b[2] & 0xFF) << 8) + ($b[3] & 0xFF);	               
    }

    function shortToByteArray($s) {
        $shortBuf = array(0,0);
        for($i=0;$i<2;$i++) {
            $offset = (2 - 1 -$i)*8;
            $shortBuf[$i] = ($this->shr32($s,$offset))& 0xFF;
       }
       return $shortBuf;
    }

    function intToByteArray($value){

        $b = array(0,0,0,0);
        $offset = 0;
        for ($i = 0; $i < 4; $i++) {
                $offset = (4 - 1 - $i) * 8;
                $b[$i] =  ($this->shr32($value,$offset)) & 0xFF;
        }
        return $b;
    }
    
    function toByte($c) {
        
        $str="0123456789ABCDEF";
        $i=0;
        for($i=0;$i<16;$i++) {
            if($str[$i]==strtoupper($c)) {
   		       return $i;	
            }
   	    }
        return 0;
    }

    function toByte2($c) {

        $str="0123456789ABCDEF";
        for($i=0;$i<16;$i++) {
            if(substr($str,$i,1)==strtoupper($c)) {
                return $i;	
            }
        }
        return 0;
    }

    function hexStringToByte($hex) {
        $len = strlen($hex);
        //echo $len;
        //echo "<br>";
        $achar = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $result= array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,);
        for($i=0;$i<$len;$i++) {
        	$achar[$i]=$hex[$i];
        }
        // $achar = toCharArray($hex);
        $pos=0;
        for ( $i = 0; $i < $len; $i++) {
            $pos = $i * 2;
            $result[$i] =  $this->toByte($achar[$pos]) << 4 | $this->toByte($achar[$pos + 1]);
        }
        return $result;
    }

    function hexStringToByte2($hex) {
	 
        $len = strlen($hex);
     
        $result = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $achar= array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 
        for($i=0;$i<$len;$i++) {
        	$achar[$i]=substr($hex,$i,1);
        }
        // $achar = toCharArray($hex);
        for ( $i = 0; $i < $len/2; $i++) {
            $pos = $i * 2;
            $result[$i] = ( $this->toByte2($achar[$pos]) * 16 )+ ( $this->toByte2($achar[$pos + 1]));
        }
        return $result;
    }

    function hexStringToByte3($hex) {
	 
        $len = strlen($hex);
     
        $result = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $achar= array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 
        for($i=0;$i<$len;$i++) {
        	$achar[$i]=substr($hex,$i,1);
        }
        // $achar = toCharArray($hex);
        for ( $i = 0; $i < $len/2; $i++) {
            $pos = $i * 2;
            $result[$i] = ( $this->toByte2($achar[$pos]) * 16 )+ ( $this->toByte2($achar[$pos + 1]));
        }
        return $result;
    }

    function bytesToHexString($bArray) {
        
        $sb="";
        
        for ($i = 0; $i <count($bArray); $i++) {
        
            $sTemp = dechex ($bArray[$i]);
            
            if (strlen($sTemp) < 2) {
                $sTemp="0" . $sTemp;   
            }
           
            $sb=$sb . $sTemp;
        } 
      
       return strtoupper($sb);
    }

    function bytesToHexString2($bArray,$len) {
    
        $sb="";
        
        for ($i = 0; $i <$len; $i++) {
        
            $sTemp = dechex ($bArray[$i]);
        
            if (strlen($sTemp) < 2) {
                $sTemp="0" . $sTemp;           
            }
       
            $sb=$sb . $sTemp;
        } 
      
       return strtoupper($sb);
    }

    function bytetoString($b) {
        $s="";

        for( $i=0;$i<count($b);$i++) {            
            $s = $s . chr($b[$i]);            
        }

        return $s;
    }

}

/*
| ---------------------------
| Class tea
| ---------------------------
*/

class tea {
 
    function shr32($x, $bits){   
        // Î»ÒÆÁ¿³¬³ö·¶Î§µÄÁ½ÖÖÇé¿ö   
        if($bits <= 0) {   
            return $x;   
        }   
        if($bits >= 32) {   
            return 0;   
        }   
        //×ª»»³É´ú±í¶þ½øÖÆÊý×ÖµÄ×Ö·û´®   
        $bin = decbin($x);   
        $l = strlen($bin);   
        //×Ö·û´®³¤¶È³¬³öÔò½ØÈ¡µ×32Î»£¬³¤¶È²»¹»£¬ÔòÌî³ä¸ßÎ»Îª0µ½32Î»   
        if($l > 32){   
            $bin = substr($bin, $l - 32, 32);   
        } elseif($l < 32) {   
            $bin = str_pad($bin, 32, '0', STR_PAD_LEFT);   
        }   
        //È¡³öÒªÒÆ¶¯µÄÎ»Êý£¬²¢ÔÚ×ó±ßÌî³ä0   
        return bindec(str_pad(substr($bin, 0, 32 - $bits), 32, '0', STR_PAD_LEFT));   
    } 

    function encrypt($content, $offset, $key, $times) { //timesÎª¼ÓÃÜÂÖÊý
        $a1 = array(0,0,0,0);
        $a2 = array(0,0,0,0);

        for ($a = 0; $a < 4; $a++) {
            $a1[$a] = $content[$a + $offset];
        }
        for ($a = 0; $a < 4; $a++) {
            $a2[$a] = $content[$a + 4 + $offset];
        }

		$tempInt = array(0,0);//byteToInt(encryptContent, offset);
        
        $sg = new stringchange();
        $tempInt[0] = $sg->byteArrayToInt($a1);
        $tempInt[1] = $sg->byteArrayToInt($a2);
 
        $y =int32($tempInt[0]);
        $z =int32($tempInt[1]);
        $sum = 0;
        $delta = 0x9e3779b9; //ÕâÊÇËã·¨±ê×¼¸øµÄÖµ
        $a = $key[0];
        $b = $key[1];
        $c = $key[2];
        $d = $key[3];
		$z1=0;
        $z2=0;
        $z3=0;
        $y1=0;
        $y2=0;
        $y3=0;
        $y4=0;

        if ($delta < 0) {
            $delta =  $delta + 4294967296;
        }

        $templong = 0;
        $tempz = 0; 
        $tempz2 = 0;

        for ($i = 0; $i < $times; $i++) {
            $sum =   $sum + $delta;
           
            if ($sum < 0) {
                $sum = $sum + 4294967296;
            }
            if ($sum > 4294967296) {
                $sum = $sum - 4294967296;
            }

            //int z1, z2, z3;
            $z1=int32($z1);
            $z2=int32($z2);
            $z3=int32($z3);

            // y += ((z << 4) + a) ^ (z + sum) ^ ((z >> 5) + b);
           // int y1, y2, y3, y4;
            $y1=int32($y1);
            $y2=int32($y2);
            $y3=int32($y3);
            $y4=int32($y4);
            
            $y1 = $z << 4;

            if ($y1 < 0) {
                $templong = $y1 + 4294967296;
            } else {
                $templong = $y1;
            }
     
            $y1 = int32( ($templong + $a));
                        
            $templong = $z + $sum;
            $y2 = int32( $templong);
            $y3 =$this->shr32($z,5); 
           
            if ($y3 < 0) {
                $templong = $y3 + 4294967296;
            } else {
                $templong = $y3;
            } 
            
           
            $tempz = $templong + $b;

            if ($tempz > 4294967296) {
                $tempz = $tempz - 4294967296;
            }

						
            $y3 = int32( $tempz);
            $y4 = $y1 ^ $y2 ^ $y3;
            if ($y4 < 0) {
                $tempz2 = $y4 + 4294967296;
            } else {
                $tempz2 = $y4;
            }

            if ($y < 0) {
                $templong =  $y + 4294967296;
            } else {
                $templong = $y;
            }

            $templong=$templong +$tempz2;

            if ($templong > 4294967296) {
                           $templong = $templong - 4294967296;
            }
            $y = int32( ($templong ));

            //z += ((y << 4) + c) ^ (y + sum) ^ ((y >> 5) + d);

            $z1 = $y << 4;
            if ($z1 < 0) {
                $templong = $z1 + 4294967296;
            } else {
                $templong = $z1;
            }

            $templong = $templong + $c;

            if ($templong > 4294967296) {
                $templong = $templong - 4294967296;
            }

            $z1 = int32( ($templong));

            $templong = $y;

            if ($templong < 0) {
                $templong = $templong + 4294967296;
            }

            $templong = $templong + $sum;

            if ($templong < 0) {
                $templong = $templong + 4294967296;
            }

            if ($templong > 4294967296) {
                $templong = $templong - 4294967296;
            }

            $z2 = int32( $templong);

            $z3 = $this->shr32($y , 5);
            if ($z3 < 0) {
                $templong = $z3 + 4294967296;
            } else {
                $templong = $z3;
            }

            $templong = $templong + $d;

            if ($templong > 4294967296) {
                $templong = $templong - 4294967296;
            }
            $z3 = int32( ($templong));

            $tempz = $z;

            if ($tempz < 0) {
                $tempz = $tempz + 4294967296;
            }
            if ($tempz > 4294967296) {
                $tempz = $tempz - 4294967296;
            }

            $z4 = 0;
            $z4 = ($z1 ^ $z2 ^ $z3);

            if ($z4 < 0) {
                $templong = $z4 + 4294967296;
            } else {
                $templong = $z4;
            }

            $tempz = $tempz + $templong;
            if ($tempz > 4294967296) {
                $tempz = $tempz - 4294967296;
            }
            $z = int32( $tempz);
  					
        }

        if ($y < 0) {
            $templong = $y + 4294967296;
        } else {
            $templong = $y;
        }		

        $tempInt[0] = int32( $this->TEA_ntoh($templong, true));
           
        if ($z < 0) {
            $templong = $z + 4294967296;
        } else {
            $templong = $z;
        }

        $tempInt[1] = int32( $this->TEA_ntoh($templong, true));
 
        return $this->ByteToByte($this->intToByte($tempInt, 0));

    }

    function decrypt($encryptContent, $offset, $key,$times) {
        $a1 = array(0,0,0,0);
        $a2 = array(0,0,0,0);
		$a=0;
        for ($a = 0; $a < 4; $a++) {
            $a1[$a] = $encryptContent[$a + $offset];
        }
        for ($a = 0; $a < 4; $a++) {
            $a2[$a] = $encryptContent[$a + 4 + $offset];
        }

        $tempInt = array(0,0); //byteToInt(encryptContent, offset);
        $sg = new stringchange();
        $tempInt[0] = $sg->byteArrayToInt($a1);
        $tempInt[1] = $sg->byteArrayToInt($a2);

        $y = int32($tempInt[0]);
         $z = int32($tempInt[1]);
        
        $sum = 0xE3779B90;
        $delta = 0x9e3779b9; //ÕâÊÇËã·¨±ê×¼¸øµÄÖµ
        $a = $key[0];
        $b = $key[1];
        $c = $key[2];
        $d = $key[3];
  
        if ($sum < 0) {
            $sum = $sum + 4294967296;
        }
        if ($delta < 0) {
            $delta =  $delta + 4294967296;
        }

        $templong = 0;
        $tempz = 0;
        $tempz2 = 0;
        $z1=0;
        $z2=0;
        $z3=0;
        $y1=0;
        $y2=0;
        $y3=0;
        $y4=0;
        for ($i = 0; $i < $times; $i++) {
 					
 				
            //z1, z2, z3;
            $z1=int32($z1);
            $z2=int32($z2);
            $z3=int32($z3);
            
            $z1 = $y << 4;
           
          	   
            if ($z1 < 0) {
                $templong =  $z1 + 4294967296;
            } else {
                $templong = $z1;
            }

            $z1 = int32( $templong + $c);
					
            $templong = $y;

            if ($templong < 0) {
                $templong = $templong + 4294967296;
            }

            $templong = $templong + $sum;

            if ($templong < 0) {
                $templong = $templong + 4294967296;
            }
            $z2 = int32( $templong);

            $z3 = $this->shr32($y , 5);
            if ($z3 < 0) {
                $templong = $z3 + 4294967296;
            } else {
                $templong = $z3;
            }

            $z3 = int32( ($templong + $d));
	
            $tempz = $z;

            if ($tempz < 0) {
                $tempz = $tempz + 4294967296;
            }
             $z4 = 0;
            $z4 = ($z1 ^ $z2 ^ $z3);

            if ($z4 < 0) {
                $templong = $z4 + 4294967296;
            } else {
                $templong = $z4;
            }

            $tempz = $tempz - $templong;

            $z = int32( $tempz);

            // z -=    ((y << 4) + c)        ^ (y + sum) ^ ((y >> 5) + d);
            //int y1, y2, y3, y4;
				
			$y1=int32($y1);
			$y2=int32($y2);
			$y3=int32($y3);
			$y4=int32($y4);
					
            $y1 = $z << 4;

            if ($y1 < 0) {
                $templong = $y1 + 4294967296;
            } else {
                $templong = $y1;
            }

            $y1 = int32( ($templong + $a));

            $templong = $z + $sum;
            $y2 = int32( $templong);
            $y3 = $this->shr32($z,5);
            if ($y3 < 0) {
                $templong = $y3 + 4294967296;
            } else {
                $templong = $y3;
            }
            $tempz = $templong + $b;
            $y3 = int32( $tempz);
            $y4 = $y1 ^ $y2 ^ $y3;
            if ($y4 < 0) {
                $tempz2 = $y4 + 4294967296;
            } else {
                $tempz2 = $y4;
            }
            //y -= ((z << 4) + a) ^ (z + sum) ^ ((z >> 5) + b);
            if ($y < 0) {
                $templong = $y + 4294967296;
            } else {
                $templong = $y;
            }

            $y = int32( ($templong - $tempz2));

            $sum = $sum -  $delta;
            if ($sum < 0) {
                $sum = $sum + 4294967296;
            }
            
          
        }

        if ($y < 0) {
            $templong =  $y + 4294967296;
        } else {
            $templong = $y;
        }

        $tempInt[0] = int32( $this->TEA_ntoh($templong, true));

        if ($z < 0) {
            $templong = $z + 4294967296;
        } else {
            $templong = $z;
        }

        $tempInt[1] = int32( $this->TEA_ntoh($templong, true));

        // return tempInt;
        return $this->ByteToByte($this->intToByte($tempInt, 0));
    }

    function TEA_ntoh($netlong, $_isNetByte /*= false*/) {
        
        $x = ($netlong & 0xff) << 24;
        $x |= ($netlong & 0xff00) << 8;
        $x |= $this->shr32(($netlong & 0xff0000),8);// >> 8;
        $x |= $this->shr32(($netlong & 0xff000000),24);// >> 24;


		if ($_isNetByte==true) {
            return $x;
		} else {
            return $netlong;
		}
        
    }

    function byteToInt($content, $offset) {

        $result =array(); //³ýÒÔ2µÄn´Î·½ == ÓÒÒÆnÎ» ¼´ content.length / 4 == content.length £¾£¾ 2
        for ($i = 0, $j = $offset; $j < count(content); $i++, $j += 4) {
            $result[$i] = transform($content[$j + 3]) |
            transform($content[$j + 2]) << 8 |
            transform($content[$j + 1]) << 16 |
            int32( $content[j] << 24);
        }
        return $result;

    }

    function ByteToByte($b) {

        $i = count($b);
        if ($i % 4 != 0) {
            return $b;
        }

        $re = array ();

        for ( $j = 0; $j < count($b); ) {
            $re[$j] = $b[$j + 3];
            $re[$j + 1] = $b[$j + 2];
            $re[$j + 2] = $b[$j + 1];
            $re[$j + 3] = $b[$j];

            $j = $j + 4;
        }

        return $re;
    }

    function  intToByte($content, $offset) {
       $result = array(); //³ËÒÔ2µÄn´Î·½ == ×óÒÆnÎ» ¼´ content.length * 4 == content.length £¼£¼ 2
        for ($i = 0, $j = $offset; $j < (count($content)<<2); $i++, $j += 4) {
            $result[$j + 3] =   ($content[$i] & 0xff);
            $result[$j + 2] =   (($content[$i] >> 8) & 0xff);
            $result[$j + 1] =   (($content[$i] >> 16) & 0xff);
            $result[$j] =   (($content[$i] >> 24) & 0xff);
        }
        return $result;
    }

    function transform($temp) {
        $tempInt = int32( $temp);
        if ($tempInt < 0) {
            $tempInt += 256;
        }
        return $tempInt;
    }

    function encryptByTea($info) {
        $KEY = array(1952801070, 778923887,1848520307, 1700867630);
        $result =array();// new byte[info.length];
        $offset = 0;
        for ($offset = 0; $offset < count($info); $offset += 8) {
            $tempEncrpt = $this->encrypt($info, $offset, $KEY, 16);
             
            for($j=0;$j<8;$j++)
            {
            	$result[$offset + $j]=$tempEncrpt[$j];
            //System.arraycopy(tempEncrpt, 0, result, offset, 8);
          	}
        }
				 
        return $result;
    }

    function decryptByTea($secretInfo) {
        //$decryptStr = null;
       // echo count($secretInfo);
      //  echo "<br>";
        $result =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);// new byte[secretInfo.length];
        $decryptStr=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);// new byte[secretInfo.length];
        $KEY = array(1952801070, 778923887,1848520307, 1700867630);
        $offset = 0;
        for ($offset = 0; $offset <count($secretInfo); $offset += 8) {
            $decryptStr =$this->decrypt($secretInfo, $offset, $KEY, 16);
            for($j=0;$j<8;$j++) {
            	$result[$offset + $j]=$decryptStr[$j];
            //System.arraycopy(tempEncrpt, 0, result, offset, 8);
          	}
        }
        
        return $result;
    }
		
}

/*
| ---------------------------
| Class otpdatetime
| ---------------------------
*/

class otpdatetime{
	
    public $year;
	public $month;
	public $day;
	public $hour;
	public $minute;
	public $second;
	
    function __construct()  {
	 
    	$this->year=2009;
    	$this->month=1;
    	$this->day=1;
    	$this->hour=0;
    	$this->minute=0;
    	$this->second=0;
	}

	function getdatetimeString(){
		return $this->year . "-" . $this->month . "-" . $this->day . " " . $this->hour . ":" . $this->minute . ":" . $this->second;
	}
}

/*
| ---------------------------
| Class tokeninfoc
| ---------------------------
*/

class tokeninfoc {

    public  $KeyLen;
    public  $Key;
    public  $InitTimeYear;
    public  $InitTimeMonth;
    public  $InitTimeDay;
    public  $InitTimeHour;
    public  $InitTimeMinute;
    public  $InitTimeSecond;
    public  $LastLoginTotalMovingValue;
    public  $LastLoginSecond;
    public  $TokenTimeOffsetMinute;
    public  $TokenTimeOffsetSecond;
    public  $OTPType;
    public  $OTPChangeTime;
    public  $OTPCheckPassType;
    public  $LastchangellTotalMovingValue;
    public  $othersByte;

    function __construct()  {

        $this->KeyLen = 0;
        $this->Key = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

        $this->InitTimeYear = 0;
        $this->InitTimeMonth = 0;
        $this->InitTimeDay = 0;
        $this->InitTimeHour = 0;
        $this->InitTimeMinute = 0;
        $this->InitTimeSecond = 0;
        $this->LastLoginTotalMovingValue = 0;
        $this->LastLoginSecond = 0;
        $this->TokenTimeOffsetMinute = 0;
        $this->TokenTimeOffsetSecond = 0;
        $this->OTPType = 0;
        $this->OTPChangeTime = 0;
        $this->OTPCheckPassType = 0;
        $this->LastchangellTotalMovingValue = 0;
        $this->othersByte = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

    }

    function settokeninfo($info) {
        $sg = new stringchange();

        $k =array(0,0) ;
        $k[0] = $info[1];
        $k[1] = $info[0];
        $this->KeyLen =$sg->byteArrayToShort($k);
					
        $i = 0;
        for ($i = 0; $i < $this->KeyLen ; $i++) {
            $this->Key[$i] = $info[$i + 2];  
        }
        $k[0] = $info[53];
        $k[1] = $info[52];

        $this->InitTimeYear =   $sg->byteArrayToShort($k);

        $this->InitTimeMonth = $info[54];
        $this->InitTimeDay = $info[55];
        $this->InitTimeHour = $info[56];
        $this->InitTimeMinute = $info[57];
        $this->InitTimeSecond = $info[58];
        $k1 = array(0,0,0,0);
        $k1[0] = $info[62];
        $k1[1] = $info[61];
        $k1[2] = $info[60];
        $k1[3] = $info[59];
        $this->LastLoginTotalMovingValue = $sg->byteArrayToInt($k1);
         
        $this->LastLoginSecond = $info[63];

        $k1[0] = $info[67];
        $k1[1] = $info[66];
        $k1[2] = $info[65];
        $k1[3] = $info[64];

        $this->TokenTimeOffsetMinute = $sg->byteArrayToInt($k1);
        $this->TokenTimeOffsetSecond = $info[68];
        $this->OTPType = $info[69];
        $this->OTPChangeTime = $info[70];
        $this->OTPCheckPassType = $info[71];

		$k1[0] = $info[75];
        $k1[1] = $info[74];
        $k1[2] = $info[73];
        $k1[3] = $info[72];
         
        // echo $k1[0] . "  " . $k1[1] . "  " . $k1[2]  . "  " . $k1[3] . "<br>";
         
        $this->LastchangellTotalMovingValue = $sg->byteArrayToInt($k1);
         
        // echo "changell:" . $this->LastchangellTotalMovingValue;
        // echo "<br>";
         
        for ($i = 0; $i < 44; $i++) {
            $this->othersByte[$i] = $info[$i + 76];
        }
         
        return $this;

     }

     function   gettokeninfo($stinfo) {
           $sg = new stringchange();
           $info[] = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
           $k = array(0,0,0,0);
           $sk=array(0,0);

         $sk = $sg->shortToByteArray($stinfo->KeyLen);
 
         $info[0] = $sk[1];
         $info[1] = $sk[0];
 
         
         for ($i = 0; $i < 50 ; $i++) {
             $info[$i + 2] = $stinfo->Key[$i];
         }

         $sk = $sg->shortToByteArray($stinfo->InitTimeYear);

         $info[52] = $sk[1];
         $info[53] = $sk[0];

         $info[54] = $stinfo->InitTimeMonth;
         $info[55] = $stinfo->InitTimeDay;
         $info[56] = $stinfo->InitTimeHour;
         $info[57] = $stinfo->InitTimeMinute;
         $info[58] = $stinfo->InitTimeSecond;

         $k = $sg->intToByteArray($stinfo->LastLoginTotalMovingValue);

         $info[59] = $k[3];
         $info[60] = $k[2];
         $info[61] = $k[1];
         $info[62] = $k[0];

         $info[63] = $stinfo->LastLoginSecond;
         $k = $sg->intToByteArray($stinfo->TokenTimeOffsetMinute);
         $info[64] = $k[3];
         $info[65] = $k[2];
         $info[66] = $k[1];
         $info[67] = $k[0];

         $info[68] = $stinfo->TokenTimeOffsetSecond;
         $info[69] = $stinfo->OTPType;
         $info[70] = $stinfo->OTPChangeTime;
         $info[71] = $stinfo->OTPCheckPassType;

		  
		
		 $k = $sg->intToByteArray($stinfo->LastchangellTotalMovingValue);

         $info[72] = $k[3];
         $info[73] = $k[2];
         $info[74] = $k[1];
         $info[75] = $k[0];
	
		 
		
         for ($i = 0; $i < 44; $i++) {
             $info[$i + 76] = $stinfo->othersByte[$i];
         }

         return $info;
     }

}

/*
| ---------------------------
| Class tokeninfo
| ---------------------------
*/

class tokeninfo {

    public  $KeyLen;
    public  $Key;
    public  $InitTimeYear;
    public  $InitTimeMonth;
    public  $InitTimeDay;
    public  $InitTimeHour;
    public  $InitTimeMinute;
    public  $InitTimeSecond;
    public  $LastLoginTotalMovingValue;
    public  $LastLoginSecond;
    public  $TokenTimeOffsetMinute;
    public  $TokenTimeOffsetSecond;
    public  $OTPType;
    public  $OTPChangeTime;
    public  $OTPCheckPassType;
    public  $othersByte;

    function __construct()  {

        $this->KeyLen = 0;
        $this->Key = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

        $this->InitTimeYear = 0;
        $this->InitTimeMonth = 0;
        $this->InitTimeDay = 0;
        $this->InitTimeHour = 0;
        $this->InitTimeMinute = 0;
        $this->InitTimeSecond = 0;
        $this->LastLoginTotalMovingValue = 0;
        $this->LastLoginSecond = 0;
        $this->TokenTimeOffsetMinute = 0;
        $this->TokenTimeOffsetSecond = 0;
        $this->OTPType = 0;
        $this->OTPChangeTime = 0;
        $this->OTPCheckPassType = 0;
        $this->othersByte = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

    }

    function settokeninfo($info) {
         
        $sg = new stringchange();

        $k =array(0,0) ;
        $k[0] = $info[1];
        $k[1] = $info[0];
        $this->KeyLen =$sg->byteArrayToShort($k);
					
        $i = 0;
        for ($i = 0; $i < $this->KeyLen ; $i++) {
            $this->Key[$i] = $info[$i + 2];  
        }
        $k[0] = $info[53];
        $k[1] = $info[52];

        $this->InitTimeYear =   $sg->byteArrayToShort($k);

        $this->InitTimeMonth = $info[54];
        $this->InitTimeDay = $info[55];
        $this->InitTimeHour = $info[56];
        $this->InitTimeMinute = $info[57];
        $this->InitTimeSecond = $info[58];
        $k1 = array(0,0,0,0);
        $k1[0] = $info[62];
        $k1[1] = $info[61];
        $k1[2] = $info[60];
        $k1[3] = $info[59];
        $this->LastLoginTotalMovingValue = $sg->byteArrayToInt($k1);
        $this->LastLoginSecond = $info[63];

        $k1[0] = $info[67];
        $k1[1] = $info[66];
        $k1[2] = $info[65];
        $k1[3] = $info[64];

        $this->TokenTimeOffsetMinute = $sg->byteArrayToInt($k1);
        $this->TokenTimeOffsetSecond = $info[68];
        $this->OTPType = $info[69];
        $this->OTPChangeTime = $info[70];
        $this->OTPCheckPassType = $info[71];

        for ($i = 0; $i < 48; $i++) {
            $this->othersByte[$i] = $info[$i + 72];
        }
         
        return $this;

    }

    function gettokeninfo($stinfo) {
          
        $sg = new stringchange();
        $info[] = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $k = array(0,0,0,0);
        $sk=array(0,0);

        $sk = $sg->shortToByteArray($stinfo->KeyLen);
 
        $info[0] = $sk[1];
        $info[1] = $sk[0];
 
        for ($i = 0; $i < 50 ; $i++) {
            $info[$i + 2] = $stinfo->Key[$i];
        }

        $sk = $sg->shortToByteArray($stinfo->InitTimeYear);

        $info[52] = $sk[1];
        $info[53] = $sk[0];

        $info[54] = $stinfo->InitTimeMonth;
        $info[55] = $stinfo->InitTimeDay;
        $info[56] = $stinfo->InitTimeHour;
        $info[57] = $stinfo->InitTimeMinute;
        $info[58] = $stinfo->InitTimeSecond;

        $k = $sg->intToByteArray($stinfo->LastLoginTotalMovingValue);

        $info[59] = $k[3];
        $info[60] = $k[2];
        $info[61] = $k[1];
        $info[62] = $k[0];

        $info[63] = $stinfo->LastLoginSecond;
        $k = $sg->intToByteArray($stinfo->TokenTimeOffsetMinute);
        $info[64] = $k[3];
        $info[65] = $k[2];
        $info[66] = $k[1];
        $info[67] = $k[0];

        $info[68] = $stinfo->TokenTimeOffsetSecond;
        $info[69] = $stinfo->OTPType;
        $info[70] = $stinfo->OTPChangeTime;
        $info[71] = $stinfo->OTPCheckPassType;

        for ($i = 0; $i < 48; $i++) {
            $info[$i + 72] = $stinfo->othersByte[$i];
        }

        return $info;
    }

}
 
/*
| ---------------------------
| Class seamoonapi
| ---------------------------
*/

class seamoonapi {
   
    //  $strSeamoon ="KingKey20050328.88888888889999999999";
    // $strSNStringKey = "KingKey20050328.88888888889999999999";
  
    function ConvertHex2Bin($hexdata) {
    	$bindata = "";
    	for ($i=0;$i<strlen($hexdata);$i+=2) {
    		$bindata.=chr(hexdec(substr($hexdata,$i,2)));
    	}
    	return $bindata;
    }

    function HashHmac($algo, $data, $key, $raw_output = false) {

    	$algo = strtolower($algo);
    	$pack = 'H'.strlen($algo('test'));
    	$size = 64;
    	$opad = str_repeat(chr(0x5C), $size);
    	$ipad = str_repeat(chr(0x36), $size);

    	if (strlen($key) > $size) {
    		$key = str_pad(pack($pack, $algo($key)), $size, chr(0x00));
    	}
    	else {
    		$key = str_pad($key, $size, chr(0x00));
    	}

    	for ($i = 0; $i < strlen($key) - 1; $i++) {
    		$opad[$i] = $opad[$i] ^ $key[$i];
    		$ipad[$i] = $ipad[$i] ^ $key[$i];
    	}

    	$output = $algo($opad.pack($pack, $algo($ipad.$data)));

    	return ($raw_output) ? pack($pack, $output) : $output;
    }

    function ComputeOathTruncate($hash, $length = 6) {
    	// Convert to decimal
    	foreach(str_split($hash,2) as $hex) {
    		$hmac_result[]=hexdec($hex);
    	}

    	// Find offset
    	$offset = 0;
    	$offset = $hmac_result[19] & 0xf;

    	// Algorithm from RFC
    	return
    	substr(str_repeat('0',$length).((
    		(($hmac_result[$offset+0] & 0x7f) << 24 ) |
    		(($hmac_result[$offset+1] & 0xff) << 16 ) |
    		(($hmac_result[$offset+2] & 0xff) << 8 ) |
    		($hmac_result[$offset+3] & 0xff)
    	) % pow(10,$length)),-$length); // & 0x7FFFFFFF before the pow()
    }

    function ComputeOathTOTP($key, $counter) {

    	// Counter
    	//the counter value can be more than one byte long, so we need to go multiple times
    	$cur_counter = array(0,0,0,0,0,0,0,0);
    	for($i=7;$i>=0;$i--) {
    		$cur_counter[$i] = pack ('C*', $counter);
    		$counter = $counter >> 8;
    	}
    	$bin_counter = implode($cur_counter);
    	// Pad to 8 chars
    	if (strlen ($bin_counter) < 8) {
    		$bin_counter = str_repeat(chr(0), 8 - strlen($bin_counter)) . $bin_counter;
    	}

    	// HMAC hash
    	 	
    	$hash = $this->HashHmac('sha1', $bin_counter, $key);
    	 	
    	return $hash;
    }

    function GetOTPPassword($key,$interval,$passwordlen) {
	 
        //$seed_bin = ConvertHex2Bin($key);
        $i=0;
        $seed_bin="";
        for($i=0;$i<count($key);$i++) {
        	$seed_bin.=chr($key[$i]);
        }
         
        $password_len = $passwordlen; 
        $timer = $interval;
     
    	return	$this->ComputeOathTruncate($this->ComputeOathTOTP($seed_bin,$timer),$password_len);
    }

    function getOTPpassword2($key,$interval,$passwordlen,$itimes)  {
    
        for($i=0;$i<count($key);$i++) {
        	$seed_bin.=chr($key[$i]);
        }

        $password_len = $passwordlen; 
         
        return	$this->ComputeOathTruncate($this->ComputeOathTOTP($seed_bin,$itimes),$password_len);
    }

    function CheckOTPpassword($key,$passwordlen,$password,$itimes) {
    	//$timesecond=time();
    	
    	//$itimes=10 * (60/$interval);
        	 
    	if($password==$this->GetOTPPassword($key,$itimes,$passwordlen)) {
    			 
    		return 1;	
    	}	
    	 
    	return 0;
    }

    function ITSecurity_CheckCB_v6($pCB) {

        //cMd5InputStr, cMd5ResultStr, cTmpCB;
        //int  totoa_md5StrLen,i, iCBLen,j;
		$strSeamoon="KingKey20050328.88888888889999999999";
       
        $iCBLen = strlen($pCB);

        $j = 0;
        $cTmpCB=trim($pCB) ;

        $pCB= $cTmpCB;

        $iCBLen =strlen($pCB);

 
        if(substr($pCB,6,1)  == "6") {
                
            if($iCBLen != 291) {
                return -1;
            }

            $cMd5InputStr= $strSeamoon;

            $totoa_md5StrLen = strlen($strSeamoon) ;

            $cMd5InputStr=$cMd5InputStr . substr($pCB,0,17);

            $totoa_md5StrLen = $totoa_md5StrLen  + 17;
 
            $cMd5InputStr=$cMd5InputStr . substr($pCB,49,strlen($pCB));
                
            $totoa_md5StrLen = $totoa_md5StrLen + 242;

                   
            $cMd5ResultStr=strtoupper(md5($cMd5InputStr)) ;
			 
            if (substr($pCB,17,32)==$cMd5ResultStr) {

                return 1;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    function KingKey_HOTP_GetInfoFromCB($pInitCB) {
             
        if(strlen($pInitCB) != 291) {
            return 0;
        }

        $tmpByteInit =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tmpByteInit2 =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tmpByteResult=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

        //$TmpLen;
        //String tmpStr;

        $tmpStr =substr($pInitCB,49, 289);

        $t = new tea();

        $cg = new stringchange();
        $tmpByteInit = $cg->hexStringToByte($tmpStr);

		$kk=0;
		for($kk=0;$kk<count($tmpByteInit);$kk++) {
			$tmpByteInit2[$kk]=$tmpByteInit[$kk];
		}
			
        $tmpByteResult = $t->decryptByTea($tmpByteInit2);

		$tinfo=new tokeninfo();
        $tinfo=$tinfo->settokeninfo($tmpByteResult);

        return $tinfo;
    }

    function KingKey_HOTP_GetNewCB($pcInitCB, $stTokenInfo) {
        
        //TEA  encrypt
        $pcResultCB=$pcInitCB;
                
        $tmpByteInit =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tmpByteResult=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

        $tmpByteInit = $stTokenInfo->gettokeninfo($stTokenInfo);

    	for($i=0;$i<count($tmpByteInit);$i++) {
    		//echo $tmpByteInit[$i];
    		//echo "<br>";
    	}

        $t = new tea();
        $tmpByteResult = $t->encryptByTea($tmpByteInit);
         
        $cg = new stringchange();
        $tmpStr = $cg->bytesToHexString($tmpByteResult);
     
     	$pcResultCB = substr($pcInitCB,0, 49) . $tmpStr . "==";
     
     	$strSNStringKey = "KingKey20050328.88888888889999999999";
        
        $cMd5InputStr = $strSNStringKey;
     
        $cMd5InputStr = $cMd5InputStr . substr($pcInitCB,0, 17);
     
        $cMd5InputStr = $cMd5InputStr . substr($pcResultCB,49, 289);
      
        $cMd5ResultStr = strtoupper(md5($cMd5InputStr));
     
        $pcResultCB = substr($pcResultCB,0, 17) . $cMd5ResultStr .  substr($pcResultCB,49,291);
        return $pcResultCB;
    }

    function KingKey_HOTP_GetSpaceDayBetweenLastTime($SpaceMovingValue, $IntervalInSecond) {  

        if($SpaceMovingValue <= 0) {
            return 0;
        }

        if(($IntervalInSecond != 60) && ($IntervalInSecond != 30) && ($IntervalInSecond != 20)) {
            return 0;
        }

        $lTotalSeconds = $SpaceMovingValue * $IntervalInSecond;

        $TotalDays =(int)($lTotalSeconds / 86400); //Ò»Ìì86400Ãë

        return $TotalDays;
    }

    function GetTotalMovingValueOfNow($IntervalInSecond){
           
        $TotalMovingValue = 0;
        $iTotalSeconds = 0;

        if(($IntervalInSecond != 60) && ($IntervalInSecond != 30) && ($IntervalInSecond != 20)) {
            return 0;
        }
		 
        $TotalMovingValue =(int)( time() / $IntervalInSecond);

        return $TotalMovingValue;
    }

    function getotppasswords($pInitCB) {

		$pInitCB=trim($pInitCB);
       
        $stHotpInfo=new tokeninfo();
        
        $OTPCompareResul=1;

        $sg=new stringchange();

        if(($pInitCB=="")) {
            return "-1";
        }
        
        if(strlen($pInitCB)<200) {
        	return "-1";
        }
        
        if(substr($pInitCB,6,1) == "7") { 
            return  "-1"; 
        }

        $checkInitCBResult= $this->ITSecurity_CheckCB_v6($pInitCB);

        if($checkInitCBResult != 1) {
            return "-1";
        }

        if($pInitCB[6] != "6") {
            return "-1";
        }

		$stHotpInfo=$this->KingKey_HOTP_GetInfoFromCB($pInitCB);
		
        if($stHotpInfo =="") {
            return "-1";
        }

        $lTotalMovingValue =$this->GetTotalMovingValueOfNow($stHotpInfo->OTPChangeTime); 
                 
        $iTimeWindow = 10;
        
 
		if($stHotpInfo->OTPChangeTime==30) {
			$iTimeWindow = $iTimeWindow * 2;
		} elseif ($stHotpInfo->OTPChangeTime==20) {
			$iTimeWindow = $iTimeWindow * 3;
		} else if($stHotpInfo->OTPChangeTime==60) {
			$iTimeWindow = $iTimeWindow;
		} else {
			return "300";
		}
	
        if($stHotpInfo->OTPType==1){
         	$OTPLen=6;
        } else {
        	$OTPLen=8;
        }

		$retrunstr="";
		
        for($i=-1 * $iTimeWindow + $lTotalMovingValue + $stHotpInfo->TokenTimeOffsetMinute;$i<=$iTimeWindow + $lTotalMovingValue + $stHotpInfo->TokenTimeOffsetMinute;$i++) {
			$retrunstr= $retrunstr . $this->GetOTPPassword($stHotpInfo->Key,$i,$OTPLen) . ",";
		}
			
		if(strlen($retrunstr)>1) {
			$retrunstr= substr($retrunstr,0,strlen($retrunstr)-1);
		}

       return $retrunstr;      
    }

    function GetOATHUnlockPIN($pInitCB,$pChanPassword) {
		
        $pInitCB=trim($pInitCB);
		$stHotpInfo=new tokeninfo();
        
        
        $OTPCompareResul=1;

        $sg=new stringchange();

        if($pInitCB=="") {
            return "-1";
        }
        
        if(strlen($pInitCB)<200) {
        	return "-1";
        }
        
        if(substr($pInitCB,6,1) == "7") {
            return  "-1"; 
        }

        $checkInitCBResult= $this->ITSecurity_CheckCB_v6($pInitCB);
 
        if($checkInitCBResult != 1) {
            return "-1";
        }

        if($pInitCB[6] != "6") {
            return "-1";
        }
 
		$stHotpInfo=$this->KingKey_HOTP_GetInfoFromCB($pInitCB);
		
        if($stHotpInfo =="") {
            return "-1";
        }
  
        $OTPLen=6;
       
        $i=(int)$pChanPassword;

		$retrunstr="";
	
		$retrunstr=  $this->GetOTPPassword($stHotpInfo->Key,$i,$OTPLen) ;
      

        return $retrunstr;
    }

    function checkpassword($pInitCB,$pPassword) {
       	
        $pInitCB=trim($pInitCB);
        $stHotpInfo=new tokeninfo();
        
        //byte	OTP6Len[]=new byte[6],OTP8Len[]=new byte[8];
        //int		iLastTimebettwenDays;
        //int		iTimeWindow;
        $OTPCompareResul=1;

        $sg=new stringchange();

        if(($pInitCB=="") || ($pPassword == "")) {
            return "-1";
        }
        
        if(strlen($pInitCB)<200) {
        	return "-1";
        }
        
        if(substr($pInitCB,6,1) == "7") {
            $seaotp=new seamoonsea();
            return $seaotp->checkpasswordsea($pInitCB,$pPassword);   
        }

        $checkInitCBResult= $this->ITSecurity_CheckCB_v6($pInitCB);
 
        $pResultCB= $pInitCB;

        if($checkInitCBResult != 1) {
            return "-1";
        }

        if($pInitCB[6] != "6") {
            return "-1";
        }

        if(strlen($pPassword)!=6 && strlen($pPassword) !=8) {
            return "300";
        }

		$stHotpInfo=$this->KingKey_HOTP_GetInfoFromCB($pInitCB);
        
        if($stHotpInfo =="") {
            return "-1";
        }

        $lTotalMovingValue =$this->GetTotalMovingValueOfNow($stHotpInfo->OTPChangeTime);
 
        $iLastTimebettwenDays = $this->KingKey_HOTP_GetSpaceDayBetweenLastTime($lTotalMovingValue - $stHotpInfo->LastLoginTotalMovingValue, $stHotpInfo->OTPChangeTime );
 
        // < 1¸öÔÂ
        if($iLastTimebettwenDays <= 30) {
            $iTimeWindow = 5;
        } else if(($iLastTimebettwenDays > 30) && ($iLastTimebettwenDays <= 90)) {
            $iTimeWindow = 10;
        } else if(($iLastTimebettwenDays > 90) && ($iLastTimebettwenDays <= 180)) {
            $iTimeWindow = 15;
        } else if(($iLastTimebettwenDays > 180) && ($iLastTimebettwenDays <= 360)) {
            $iTimeWindow = 30;
        } else {
            $iTimeWindow = 45;
        }

	
		if($stHotpInfo->OTPChangeTime==30) {
			$iTimeWindow = $iTimeWindow * 2;
		} elseif ($stHotpInfo->OTPChangeTime==20) {
		  $iTimeWindow = $iTimeWindow * 3;
		} else if($stHotpInfo->OTPChangeTime==60) {
			$iTimeWindow = $iTimeWindow;
		} else {
			return "300";
		}
	
        if($stHotpInfo->OTPType==1) {
         	$OTPLen=6;
        }
        else {
        	$OTPLen=8;
        }

		for($i=-1 * $iTimeWindow ;$i<=$iTimeWindow ;$i++) {
        	  
        	if( $i+ $lTotalMovingValue <= $stHotpInfo->LastLoginTotalMovingValue) {
                continue;
            }
				
			if( $this->CheckOTPpassword($stHotpInfo->Key,$OTPLen,$pPassword,$i+ $lTotalMovingValue +  $stHotpInfo->TokenTimeOffsetMinute)==1) {
                $stHotpInfo->TokenTimeOffsetMinute =$stHotpInfo->TokenTimeOffsetMinute + $i;
                $stHotpInfo->LastLoginTotalMovingValue =  $lTotalMovingValue;

                //get new CB
                                              
                $pResultCB=$this->KingKey_HOTP_GetNewCB($pInitCB, $stHotpInfo);
												 
                return $pResultCB;
            }
 
		}

       return "0"; 
    }

    function passwordsyn($pInitCB,$pPassword) {
       	
        $pInitCB=trim($pInitCB);
        $stHotpInfo=new tokeninfo();
        
        //byte	OTP6Len[]=new byte[6],OTP8Len[]=new byte[8];
        //int		iLastTimebettwenDays;
        //int		iTimeWindow;
        $OTPCompareResul=1;

        $sg=new stringchange();

        if(($pInitCB=="") || ($pPassword == "")) {
            return "-1";
        }

		if(substr($pInitCB,6,1) == "7") {
            $seaotp=new seamoonsea();
            return $seaotp->passwordsynsea($pInitCB,$pPassword);   
        }

        $checkInitCBResult= $this->ITSecurity_CheckCB_v6($pInitCB);
 
        $pResultCB= $pInitCB;

        if($checkInitCBResult != 1) {
            return "-1";
        }

        if($pInitCB[6] != "6") {
            return "-1";
        }

        if(strlen($pPassword)!=6 && strlen($pPassword) !=8) {
            return "300";
        }

		$stHotpInfo=$this->KingKey_HOTP_GetInfoFromCB($pInitCB);
        
        if($stHotpInfo =="") {
            return "-1";
        }

        $lTotalMovingValue =$this->GetTotalMovingValueOfNow($stHotpInfo->OTPChangeTime);
 
        $iLastTimebettwenDays = $this->KingKey_HOTP_GetSpaceDayBetweenLastTime($lTotalMovingValue - $stHotpInfo->LastLoginTotalMovingValue, $stHotpInfo->OTPChangeTime );
 
        // < 18¸öÔÂ
        if($iLastTimebettwenDays <= 540) {
             $iTimeWindow = 120;
        } else {
            $iTimeWindow = 150;
        }

	
		if($stHotpInfo->OTPChangeTime==30){
			$iTimeWindow = $iTimeWindow * 2;
		} elseif ($stHotpInfo->OTPChangeTime==20) {
			$iTimeWindow = $iTimeWindow * 3;
		} else if($stHotpInfo->OTPChangeTime==60) {
			$iTimeWindow = $iTimeWindow;
		} else {
			return "300";
		}
	
        if($stHotpInfo->OTPType==1) {
         	$OTPLen=6;
        } else {
        	$OTPLen=8;
        }

  
        for($i=-1 * $iTimeWindow ;$i<=$iTimeWindow ;$i++) {
        	 
            if( $i+ $lTotalMovingValue <= $stHotpInfo->LastLoginTotalMovingValue ) {
                continue;
            }
  
			if( $this->CheckOTPpassword($stHotpInfo->Key,$OTPLen,$pPassword,$i+ $lTotalMovingValue +  $stHotpInfo->TokenTimeOffsetMinute)==1) {
                $stHotpInfo->TokenTimeOffsetMinute =$stHotpInfo->TokenTimeOffsetMinute + $i;
                $stHotpInfo->LastLoginTotalMovingValue =  $lTotalMovingValue;

                //get new CB
                                              
                $pResultCB=$this->KingKey_HOTP_GetNewCB($pInitCB, $stHotpInfo);
												 
                return $pResultCB;
            }
        
		}

       return 0;    
    }

    function GetHOTP8Len($key,$data) {
    	
        $hash = $this->HashHmac('sha1', $data, $key);
    	  
    	$str=$this->ComputeOathTruncate($hash,8);
    	 
    	return $str; 
    }

    function OCRA_FromSNInfoActiveInfoGetActivePassword($sninfo,$activeInfo) {
    	
        $sninfo=trim($sninfo);
    	$key=new seamoonchallenge();
    	$key2=new seamoonchallengeold();
    	if(strlen($sninfo)!=291) {
    		return "-1";
    	}
    	if(substr($sninfo,6,1)=="0") {
    		return $key->OCRA_FromSNInfoActiveInfoGetActivePassword($sninfo,$activeInfo);
    	} else {
    		return $key2->OCRA_FromSNInfoActiveInfoGetActivePassword($sninfo,$activeInfo);
    	}
    }

    function OCRA_GetUnlockPIN($sninfo,$activeInfo,$UnlockChallenge) {
    	
        $sninfo=trim($sninfo);
    	
        if(strlen($sninfo)!=291) {
    		return "-1";
    	}

    	$key=new seamoonchallenge();
    	$key2=new seamoonchallengeold();
    	
        if(substr($sninfo,6,1)=="0") {
    		return $key->OCRA_GetUnlockPIN($sninfo,$activeInfo,$UnlockChallenge);
    	} else {
    		return $key2->OCRA_GetUnlockPIN($sninfo,$activeInfo,$UnlockChallenge);
    	}   	
    }

    function OCRA_CheckResponse($sninfo,$activeInfo,$Challenge,$Response) {
    	
        $sninfo=trim($sninfo);
    	
        if(strlen($sninfo)!=291){
    		return "-1";
    	}

    	$key=new seamoonchallenge();
    	$key2=new seamoonchallengeold();

    	if(substr($sninfo,6,1)=="0") {
    		return $key->OCRA_CheckResponse($sninfo,$activeInfo,$Challenge,$Response);
    	} else {
    		return $key2->OCRA_CheckResponse($sninfo,$activeInfo,$Challenge,$Response);
    	}
    }

    function OCRA_Get_Response_OTPs($sninfo,$activeInfo,$Challenge) {
    	
        $sninfo=trim($sninfo);

    	if(strlen($sninfo)!=291){
    		return "-1";
    	}

    	$key=new seamoonchallenge();
    	$key2=new seamoonchallengeold();

    	if(substr($sninfo,6,1)=="0") {
    		return $key->OCRA_Get_Response_OTPs($sninfo,$activeInfo,$Challenge);
    	} else {
    		return $key2->OCRA_Get_Response_OTPs($sninfo,$activeInfo,$Challenge);
    	} 		
    }

    function OCRA_time_based_otp_check($sninfo,$activeInfo,$password){
    	
        $sninfo=trim($sninfo);
    	
        if(strlen($sninfo)!=291) {
    		return "-1";
    	}

    	$key=new seamoonchallenge();
    	$key2=new seamoonchallengeold();

    	if(substr($sninfo,6,1)=="0") {
    		return $key->OCRA_time_based_otp_check($sninfo,$activeInfo,$password);
    	} else {
    		return $key2->OCRA_time_based_otp_check($sninfo,$activeInfo,$password);
    	}
    }

    function OCRA_time_based_otp_syn($sninfo,$activeInfo,$password) {
    	
        $sninfo=trim($sninfo);
    	
        if(strlen($sninfo)!=291) {
    		return "-1";
    	}
    	$key=new seamoonchallenge();
    	$key2=new seamoonchallengeold();

    	if(substr($sninfo,6,1)=="0") {
    		return $key->OCRA_time_based_otp_syn($sninfo,$activeInfo,$password);
    	} else {
    		return $key2->OCRA_time_based_otp_syn($sninfo,$activeInfo,$password);
    	}
    }

    function OCRA_Get_Time_Based_OTPs($sninfo,$activeInfo) {
    	
        $sninfo=trim($sninfo);

    	if(strlen($sninfo)!=291){
    		return "-1";
    	}

    	$key=new seamoonchallenge();
    	$key2=new seamoonchallengeold();

    	if(substr($sninfo,6,1)=="0") {
    		return $key->OCRA_Get_Time_Based_OTPs($sninfo,$activeInfo);
    	} else {
    		return $key2->OCRA_Get_Time_Based_OTPs($sninfo,$activeInfo);
    	}
    }

    function  GetActivecode($key, $activepassword) {
           
        $s = "";

        $otp = "";
        $otp=$this->GetHOTP8Len($key,$activepassword);
             
        $s = $activepassword . substr($otp,4, 4);
        
        return $s;
    }

    function GetUnlockPIN($key,$activepassword,$UnlockChallenge) {
	
    	if(strlen($activepassword)<5) {
    		return "-1";
    	}
    	
    	$activcode=$this->GetActivecode($key,substr($activepassword,0,strlen($activepassword)-4));
    	//echo $activcode;
    	
     	if( $activcode != $activepassword ) {
     		return "-1";
     	}
    	
    	$data=substr($activepassword,0,strlen($activepassword)-4);
    		
    	$newkey=$this->HashHmac('sha1', $data, $key);
    	
    	$movingInput=intval($UnlockChallenge);
    		
    	$InfoData=array(0,0,0,0,0,0,0,0);

        $InfoData[0] = 0;
        $InfoData[1] = 0;
                $InfoData[2] = 0;
                $InfoData[3] = 0;

                $InfoData[4] =(($movingInput & 0xFF000000) >> 24);
                $InfoData[5] =(($movingInput & 0x00FF0000) >> 16);
                $InfoData[6] =(($movingInput & 0x0000FF00) >> 8);
                $InfoData[7] =(($movingInput & 0x000000FF));
    	 
    	 $sg = new stringchange();
    	
    	//echo $sg->bytesToHexString($InfoData);
    	 
    	  
    	
    	$str=$this->HashHmac('sha1',pack("H*", $sg->bytesToHexString($InfoData)),pack("H*",$newkey));
    	
    	return $this->ComputeOathTruncate($str,6);
    }

    function get_base_time_password($key,$activepassword,$val,$passwordlen) {

    	if(strlen($activepassword)<5) {
    		return "-1";
    	}
    	
    	$activcode=$this->GetActivecode($key,substr($activepassword,0,strlen($activepassword)-4));
    	 
     	if( $activcode != $activepassword ) {
     		return "-1";
     	}
    	
    	$data=substr($activepassword,0,strlen($activepassword)-4);
    		
    	$newkey=$this->HashHmac('sha1', $data, $key);
    	
    	$keybyte=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
    	 
    	$sg = new stringchange();
    	$keybyte=$sg->hexStringToByte3($newkey);
    	 
    	$str= $this->GetOTPPassword($keybyte,$val,$passwordlen);
    	 
    	return $str;

    }

    function GetResponsepassword($key,$activepassword,$Challenge,$val) {

    	if(strlen($activepassword)<5) {
    		return "-1";
    	}
    	
    	$activcode=$this->GetActivecode($key,substr($activepassword,0,strlen($activepassword)-4));
    	//echo $activcode;
    	
     	if( $activcode != $activepassword ) {
     		return "-1";
     	}
    	
    	$data=substr($activepassword,0,strlen($activepassword)-4);
    
    	$newkey=$this->HashHmac('sha1', $data, $key);
    	  
        $OCRASuit = "OCRA-1:HOTP-SHA1-6:QA40-T1M";
             
        $OCRASuitLen = strlen($OCRASuit);
        
        $DataInput=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        
        $i=0;
        
        for($i=0;$i< $OCRASuitLen;$i++) {
    		$DataInput[$i]=ord(substr($OCRASuit,$i,1));
        }
             
        $DataInput[ $OCRASuitLen]=0;
            
        for($i=0;$i<strlen($Challenge);$i++) {
    		$DataInput[ $OCRASuitLen+ $i +1 ]= ord(substr($Challenge,$i,1));
        } 
     
     	$movingInput=  $val;
    	
    	$InfoData=array(0,0,0,0,0,0,0,0);

        $InfoData[0] = 0;
        $InfoData[1] = 0;
        $InfoData[2] = 0;
        $InfoData[3] = 0;

        $InfoData[4] =(($movingInput & 0xFF000000) >> 24);
        $InfoData[5] =(($movingInput & 0x00FF0000) >> 16);
        $InfoData[6] =(($movingInput & 0x0000FF00) >> 8);
        $InfoData[7] =(($movingInput & 0x000000FF));
    	 
    	$sg = new stringchange();
    		 
        for($i=0;$i<8;$i++) {
    		$DataInput[ 128 + $OCRASuitLen+ 1 +$i] =$InfoData[$i];
    	}
    	
    	$str= $sg->bytesToHexString2($DataInput,128 + $OCRASuitLen + 9);
    	 
        return substr($this->GetHOTP8Len(pack("H*",$newkey),pack("H*",$str)),2,6);      
    }


    function GetResponsepasswordold($key,$activepassword,$Challenge) {

    	if(strlen($activepassword)<5) {
    		return "-1";
    	}
    	
    	$activcode=$this->GetActivecode($key,substr($activepassword,0,strlen($activepassword)-4));
    	//echo $activcode;
    	
     	if( $activcode != $activepassword ) {
     		return "-1";
     	}
    	
    	$data=substr($activepassword,0,strlen($activepassword)-4);
    		
    	$newkey=$this->HashHmac('sha1', $data, $key);
    	            
        $OCRASuit = "OCRA-1:HOTP-SHA1-8:QA16";
             
        $OCRASuitLen = strlen($OCRASuit);
        
        $DataInput=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        
        $i=0;
        
        for($i=0;$i< $OCRASuitLen;$i++) {
    		$DataInput[$i]=ord(substr($OCRASuit,$i,1));
        }
             
        $DataInput[ $OCRASuitLen]=0;
            
        for($i=0;$i<strlen($Challenge);$i++) {
    		$DataInput[ $OCRASuitLen+ $i +1 ]= ord(substr($Challenge,$i,1));
        }    
    	 
    	$sg = new stringchange();
    	 
    	$str= $sg->bytesToHexString2($DataInput,128 + $OCRASuitLen + 1);
    	 
        return $this->GetHOTP8Len(pack("H*",$newkey),pack("H*",$str));      

    }

}

/*
| ---------------------------
| Class seamoonchallengeold
| ---------------------------
*/

class seamoonchallengeold{
 
	function OCRA_CheckCB_v0($pCB) {
        
		$strSeamoon="KingKey20050328.88888888889999999999";
       
        $iCBLen = strlen($pCB);

        $j = 0;
        $cTmpCB=trim($pCB) ;

        $pCB= $cTmpCB;

        $iCBLen =strlen($pCB);
 
        if(substr($pCB,6,1)  == "6") {
            
            if($iCBLen != 291) {
                return -1;
            }

            $cMd5InputStr= $strSeamoon;

            $totoa_md5StrLen = strlen($strSeamoon) ;

            $cMd5InputStr=$cMd5InputStr . substr($pCB,0,17);

            $totoa_md5StrLen = $totoa_md5StrLen  + 17;

            $cMd5InputStr=$cMd5InputStr . substr($pCB,49,strlen($pCB));
                
            $totoa_md5StrLen = $totoa_md5StrLen + 242;

            $cMd5ResultStr=strtoupper(md5($cMd5InputStr)) ;
			 
            if (substr($pCB,17,32)==$cMd5ResultStr) {
                return 1;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    function OCRA_HOTP_GetInfoFromCB($pInitCB) {
             
        if(strlen($pInitCB) != 291) {
            return 0;
        }

        $tmpByteInit =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tmpByteInit2 =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tmpByteResult=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

        //$TmpLen;
        //String tmpStr;

        $tmpStr =substr($pInitCB,49, 289);

        $t = new tea();

        $cg = new stringchange();
        $tmpByteInit = $cg->hexStringToByte($tmpStr);

		 
		$kk=0;

		for($kk=0;$kk<count($tmpByteInit);$kk++) {
			$tmpByteInit2[$kk]=$tmpByteInit[$kk];
		}
			
        $tmpByteResult = $t->decryptByTea($tmpByteInit2);

		$tinfo=new tokeninfo();
        $tinfo=$tinfo->settokeninfo($tmpByteResult);

        return $tinfo;
    }

    function OCRA_HOTP_GetNewCB($pcInitCB, $stTokenInfo) {
        
        //TEA  encrypt
        $pcResultCB=$pcInitCB;
                
        $tmpByteInit =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tmpByteResult=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

        $tmpByteInit = $stTokenInfo->gettokeninfo($stTokenInfo);

        $t = new tea();
        $tmpByteResult = $t->encryptByTea($tmpByteInit);
         
        $cg = new stringchange();
        $tmpStr = $cg->bytesToHexString($tmpByteResult);
        
        $pcResultCB = substr($pcInitCB,0, 49) . $tmpStr . "==";
     
     	$strSNStringKey = "KingKey20050328.88888888889999999999";
        
        $cMd5InputStr = $strSNStringKey;
     
        $cMd5InputStr = $cMd5InputStr . substr($pcInitCB,0, 17);
     
        $cMd5InputStr = $cMd5InputStr . substr($pcResultCB,49, 289);
      
        $cMd5ResultStr = strtoupper(md5($cMd5InputStr));
     
        $pcResultCB = substr($pcResultCB,0, 17) . $cMd5ResultStr .  substr($pcResultCB,49,291);
        
        return $pcResultCB;
    }

    function OCRA_FromSNInfoActiveInfoGetActivePassword($sninfo,$activeInfo) {
		
		if($this->OCRA_CheckCB_v0($sninfo)!=1) {
			return "-1";
		}
		
		$infoc=new tokeninfoc();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();
		 
		return $si->GetActivecode($sg->bytetoString($infoc->Key),$activeInfo);
	}

	function OCRA_GetUnlockPIN($sninfo,$activeInfo,$UnlockChallenge) {
		
		if($this->OCRA_CheckCB_v0($sninfo)!=1) {
			return "-1";
		}
		
		$infoc=new tokeninfo();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();
		
		return $si->GetUnlockPIN($sg->bytetoString($infoc->Key),$activeInfo,$UnlockChallenge);
	}
	
	function OCRA_CheckResponse($sninfo,$activeInfo,$Challenge,$Response) {
		
		if($this->OCRA_CheckCB_v0($sninfo)!=1){
			return "-1";
		}
		
		$infoc=new tokeninfo();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();

		if( $si->GetResponsepasswordold($sg->bytetoString($infoc->Key),$activeInfo,$Challenge )==$Response) { 					 
            return $sninfo;
        }
  
       return "0";	
	}
	
	function OCRA_Get_Response_OTPs($sninfo,$activeInfo,$Challenge) {
		
		if($this->OCRA_CheckCB_v0($sninfo)!=1){
			return "-1";
		}
		
		$infoc=new tokeninfo();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();
	   
	   $str=   $si->GetResponsepasswordold($sg->bytetoString($infoc->Key),$activeInfo,$Challenge)  ;
                
       return $str;
	}
	
    function OCRA_time_based_otp_check($sninfo,$activeInfo,$password) {

    	if($this->OCRA_CheckCB_v0($sninfo)!=1) {
    		return "-1";
    	}
    		
    	$infoc=new tokeninfo();
    		
    	$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
    		
    	$si=new seamoonapi();
    	$sg=new stringchange();
    		
    	$lTotalMovingValue =$si->GetTotalMovingValueOfNow($infoc->OTPChangeTime);
     
        $iLastTimebettwenDays = $si->KingKey_HOTP_GetSpaceDayBetweenLastTime($lTotalMovingValue - $infoc->LastLoginTotalMovingValue, $infoc->OTPChangeTime );
     
            // < 1¸öÔÂ
        if($iLastTimebettwenDays <= 30) {
            $iTimeWindow = 5;
        } else if(($iLastTimebettwenDays > 30) && ($iLastTimebettwenDays <= 90)) {
            $iTimeWindow = 10;
        } else if(($iLastTimebettwenDays > 90) && ($iLastTimebettwenDays <= 180)) {
            $iTimeWindow = 15;
        } else if(($iLastTimebettwenDays > 180) && ($iLastTimebettwenDays <= 360)) {
            $iTimeWindow = 30;
        } else {
            $iTimeWindow = 45;
        }

    	
    	if($infoc->OTPChangeTime==30) {
    		$iTimeWindow = $iTimeWindow * 2;
    	} elseif ($infoc->OTPChangeTime==20) {
    		$iTimeWindow = $iTimeWindow * 3;
    	} else if($infoc->OTPChangeTime==60) {
    		 $iTimeWindow = $iTimeWindow;
    	} else {
    		return "300";
    	}
    	
    	for($i=-1 * $iTimeWindow;$i<=$iTimeWindow ;$i++) {
            	  
            if( $i + $lTotalMovingValue <= $infoc->LastLoginTotalMovingValue) {
                  continue;
            }
                    
            if( $si->get_base_time_password($sg->bytetoString($infoc->Key),$activeInfo,$i+ $infoc->TokenTimeOffsetMinute + $lTotalMovingValue,8)==$password) {
                $infoc->TokenTimeOffsetMinute =$infoc->TokenTimeOffsetMinute + $i;
                $infoc->LastLoginTotalMovingValue = $lTotalMovingValue;
                                                                         
                $pResultCB=$this->OCRA_HOTP_GetNewCB($sninfo, $infoc);
    												 
                return $pResultCB;
            }
         
        }

        return "0";	
    }

	
    function OCRA_time_based_otp_syn($sninfo,$activeInfo,$password) {

    	if($this->OCRA_CheckCB_v0($sninfo)!=1) {
    		return "-1";
    	}
    		
    	$infoc=new tokeninfo();
    		
    	$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
    		
    	$si=new seamoonapi();
    	$sg=new stringchange();
    		
    	$lTotalMovingValue =$si->GetTotalMovingValueOfNow($infoc->OTPChangeTime);
     
        $iLastTimebettwenDays = $si->KingKey_HOTP_GetSpaceDayBetweenLastTime($lTotalMovingValue - $infoc->LastLoginTotalMovingValue, $infoc->OTPChangeTime );
     
            // < 1¸öÔÂ
        if($iLastTimebettwenDays <= 30) {
            $iTimeWindow = 90;
        } else {
            $iTimeWindow = 120;
        }

    	if($infoc->OTPChangeTime==30) {
    		$iTimeWindow = $iTimeWindow * 2;
    	} elseif ($infoc->OTPChangeTime==20) {
    		$iTimeWindow = $iTimeWindow * 3;
    	} else if($infoc->OTPChangeTime==60) {
    		$iTimeWindow = $iTimeWindow;
    	} else {
    		return "300";
    	}
    	
        for($i=-1 * $iTimeWindow;$i<=$iTimeWindow ;$i++) {
            	  
            if( $i + $lTotalMovingValue <= $infoc->LastLoginTotalMovingValue) {
                continue;
            }
                    
            if( $si->get_base_time_password($sg->bytetoString($infoc->Key),$activeInfo,$i+ $infoc->TokenTimeOffsetMinute + $lTotalMovingValue,8)==$password) {
                $infoc->TokenTimeOffsetMinute =$infoc->TokenTimeOffsetMinute + $i;
                $infoc->LastLoginTotalMovingValue = $lTotalMovingValue;
                                                                         
                $pResultCB=$this->OCRA_HOTP_GetNewCB($sninfo, $infoc);
    												 
                return $pResultCB;
            }
     	}

        return "0";	
    }

    function OCRA_Get_Time_Based_OTPs($sninfo,$activeInfo) {
    	
        if($this->OCRA_CheckCB_v0($sninfo)!=1){
    		return "-1";
    	}
    		
    	$infoc=new tokeninfo();
    		
    	$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
    		
    	$si=new seamoonapi();
    	$sg=new stringchange();
    		
    	$lTotalMovingValue =$si->GetTotalMovingValueOfNow($infoc->OTPChangeTime);
     
        $iTimeWindow = 10;
           
             
    	
    	if($infoc->OTPChangeTime==30) {
    		$iTimeWindow = $iTimeWindow * 2;
    	} elseif ($infoc->OTPChangeTime==20) {
    		$iTimeWindow = $iTimeWindow * 3;
    	} else if($infoc->OTPChangeTime==60) {
    		$iTimeWindow = $iTimeWindow;
    	} else {
    		return "300";
    	}
    	
    	$str="";

        for($i=-1 * $iTimeWindow + $infoc->TokenTimeOffsetMinute + $lTotalMovingValue;$i<=$iTimeWindow + $infoc->TokenTimeOffsetMinute + $lTotalMovingValue ;$i++) {          
    	
    		$str= $str. $si->get_base_time_password($sg->bytetoString($infoc->Key),$activeInfo,$i,8) . "," ;
            
    	}

    	if(strlen($str)>1) {
    		$str=substr($str,0,strlen($str)-1);
    	}
        return $str;	
    }
 
}

/*
| ---------------------------
| Class seamoonchallenge
| ---------------------------
*/

class seamoonchallenge {
 
 
    function OCRA_CheckCB_v0($pCB) {
        
		$strSeamoon="KingKey20050328.88888888889999999999";
       
        $iCBLen = strlen($pCB);

        $j = 0;
        $cTmpCB=trim($pCB) ;

        $pCB= $cTmpCB;

        $iCBLen =strlen($pCB);

 
        if(substr($pCB,6,1)  == "0") {
            
            if($iCBLen != 291) {
                return -1;
            }

            $cMd5InputStr= $strSeamoon;

            $totoa_md5StrLen = strlen($strSeamoon) ;

            $cMd5InputStr=$cMd5InputStr . substr($pCB,0,17);

            $totoa_md5StrLen = $totoa_md5StrLen  + 17;

            $cMd5InputStr=$cMd5InputStr . substr($pCB,49,strlen($pCB));
                
            $totoa_md5StrLen = $totoa_md5StrLen + 242;
   
            $cMd5ResultStr=strtoupper(md5($cMd5InputStr)) ;
			 
            if (substr($pCB,17,32)==$cMd5ResultStr) {
                return 1;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    function OCRA_HOTP_GetInfoFromCB($pInitCB){
             

        if(strlen($pInitCB) != 291){
            return 0;
        }

        $tmpByteInit =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tmpByteInit2 =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tmpByteResult=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

        //$TmpLen;
        //String tmpStr;

        $tmpStr =substr($pInitCB,49, 289);

        $t = new tea();

        $cg = new stringchange();
        $tmpByteInit = $cg->hexStringToByte($tmpStr);

		$kk=0;

		for($kk=0;$kk<count($tmpByteInit);$kk++) {
			$tmpByteInit2[$kk]=$tmpByteInit[$kk];
		}
			
        $tmpByteResult = $t->decryptByTea($tmpByteInit2);

		$tinfo=new tokeninfoc();
        $tinfo=$tinfo->settokeninfo($tmpByteResult);

        return $tinfo;
    }

    function OCRA_HOTP_GetNewCB($pcInitCB, $stTokenInfo){
        
        //TEA  encrypt
        $pcResultCB=$pcInitCB;
                
        $tmpByteInit =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tmpByteResult=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

        $tmpByteInit = $stTokenInfo->gettokeninfo($stTokenInfo);

        $t = new tea();
        $tmpByteResult = $t->encryptByTea($tmpByteInit);
         
        $cg = new stringchange();
        $tmpStr = $cg->bytesToHexString($tmpByteResult);
       
        $pcResultCB = substr($pcInitCB,0, 49) . $tmpStr . "==";
     
     	$strSNStringKey = "KingKey20050328.88888888889999999999";
        
        $cMd5InputStr = $strSNStringKey;
     
        $cMd5InputStr = $cMd5InputStr . substr($pcInitCB,0, 17);
     
        $cMd5InputStr = $cMd5InputStr . substr($pcResultCB,49, 289);
      
        $cMd5ResultStr = strtoupper(md5($cMd5InputStr));
     
        $pcResultCB = substr($pcResultCB,0, 17) . $cMd5ResultStr .  substr($pcResultCB,49,291);
        
        return $pcResultCB;
    }

    function OCRA_FromSNInfoActiveInfoGetActivePassword($sninfo,$activeInfo) {
		
		if($this->OCRA_CheckCB_v0($sninfo)!=1) {
			return "-1";
		}
		
		$infoc=new tokeninfoc();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();
		
		 
		return $si->GetActivecode($sg->bytetoString($infoc->Key),$activeInfo);
	}

	function OCRA_GetUnlockPIN($sninfo,$activeInfo,$UnlockChallenge) {
		
		if($this->OCRA_CheckCB_v0($sninfo)!=1){
			return "-1";
		}
		
		$infoc=new tokeninfoc();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();
		
		return $si->GetUnlockPIN($sg->bytetoString($infoc->Key),$activeInfo,$UnlockChallenge);
	}

	function OCRA_CheckResponse($sninfo,$activeInfo,$Challenge,$Response) {

		if($this->OCRA_CheckCB_v0($sninfo)!=1){
			return "-1";
		}
		
		$infoc=new tokeninfoc();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();
		
		$lTotalMovingValue =$si->GetTotalMovingValueOfNow($infoc->OTPChangeTime);
 
        $iLastTimebettwenDays = $si->KingKey_HOTP_GetSpaceDayBetweenLastTime($lTotalMovingValue - $infoc->LastchangellTotalMovingValue, $infoc->OTPChangeTime );
 
        if($iLastTimebettwenDays <= 30) {
            $iTimeWindow = 5;
        } else if(($iLastTimebettwenDays > 30) && ($iLastTimebettwenDays <= 90)) {
            $iTimeWindow = 10;
        } else if(($iLastTimebettwenDays > 90) && ($iLastTimebettwenDays <= 180)) {
            $iTimeWindow = 15;
        } else if(($iLastTimebettwenDays > 180) && ($iLastTimebettwenDays <= 360)) {
            $iTimeWindow = 30;
        } else {
            $iTimeWindow = 45;
        }

	
		if($infoc->OTPChangeTime==30) {
			$iTimeWindow = $iTimeWindow * 2;
		} elseif ($infoc->OTPChangeTime==20) {
			$iTimeWindow = $iTimeWindow * 3;
		} else if($infoc->OTPChangeTime==60) {
			$iTimeWindow = $iTimeWindow;
		} else {
			return "300";
		}
	
        for($i=-1 * $iTimeWindow;$i<=$iTimeWindow;$i++) {
        	  
        	if( $i + $lTotalMovingValue <= $infoc->LastchangellTotalMovingValue){
                continue;
            }
 
			if( $si->GetResponsepassword($sg->bytetoString($infoc->Key),$activeInfo,$Challenge,$i + $lTotalMovingValue +  $infoc->TokenTimeOffsetMinute )==$Response){
                $infoc->TokenTimeOffsetMinute = $infoc->TokenTimeOffsetMinute + $i;
                $infoc->LastchangellTotalMovingValue = $lTotalMovingValue;
                                                                 
                $pResultCB=$this->OCRA_HOTP_GetNewCB($sninfo, $infoc);
												 
                return $pResultCB;
            }
        
		}

        return "0";	
	}
	
	function OCRA_Get_Response_OTPs($sninfo,$activeInfo,$Challenge)	{
		
		if($this->OCRA_CheckCB_v0($sninfo)!=1) {
			return "-1";
		}
		
		$infoc=new tokeninfoc();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();
		
		$lTotalMovingValue =$si->GetTotalMovingValueOfNow($infoc->OTPChangeTime);
 
        // $iLastTimebettwenDays = $si->KingKey_HOTP_GetSpaceDayBetweenLastTime($lTotalMovingValue - $infoc->LastchangellTotalMovingValue, $infoc->OTPChangeTime );
 
        $iTimeWindow = 10;
      
        if($infoc->OTPChangeTime==30) {
			$iTimeWindow = $iTimeWindow * 2;
		} elseif ($infoc->OTPChangeTime==20) {
			$iTimeWindow = $iTimeWindow * 3;
		} else if($infoc->OTPChangeTime==60) {
			$iTimeWindow = $iTimeWindow;
		} else {
			return "300";
		}
	
		$str="";

		for($i=-1 * $iTimeWindow ;$i<=$iTimeWindow ;$i++) {        	   
			$str= $str .  $si->GetResponsepassword($sg->bytetoString($infoc->Key),$activeInfo,$Challenge,$i + $infoc->TokenTimeOffsetMinute + $lTotalMovingValue)  . ",";
		}
			
		if(strlen($str)>1) {
			$str=substr($str,0,strlen($str)-1);
		}

        return $str;
	}
	
    function OCRA_time_based_otp_check($sninfo,$activeInfo,$password) {

    	if($this->OCRA_CheckCB_v0($sninfo)!=1) {
    		return "-1";
    	}
    		
    	$infoc=new tokeninfoc();
    		
    	$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
    		
    	$si=new seamoonapi();
    	$sg=new stringchange();
    		
    		
    	$lTotalMovingValue =$si->GetTotalMovingValueOfNow($infoc->OTPChangeTime);
     
        $iLastTimebettwenDays = $si->KingKey_HOTP_GetSpaceDayBetweenLastTime($lTotalMovingValue - $infoc->LastchangellTotalMovingValue, $infoc->OTPChangeTime );
     
            // < 1¸öÔÂ
        if($iLastTimebettwenDays <= 30)
            {
                    $iTimeWindow = 5;
            }
            else if(($iLastTimebettwenDays > 30) && ($iLastTimebettwenDays <= 90)) // 1~3¸öÔÂ
            {
                    $iTimeWindow = 10;
            }
            else if(($iLastTimebettwenDays > 90) && ($iLastTimebettwenDays <= 180)) // 3~6¸öÔÂ
            {
                    $iTimeWindow = 15;
            }
            else if(($iLastTimebettwenDays > 180) && ($iLastTimebettwenDays <= 360)) // 6~12¸öÔÂ
            {
                    $iTimeWindow = 30;
            }
            else // 12¸öÔÂÒÔÉÏ
            {
                    $iTimeWindow = 45;
            }

    	
    			if($infoc->OTPChangeTime==30)
    			{
    				$iTimeWindow = $iTimeWindow * 2;
    			}
    			elseif ($infoc->OTPChangeTime==20)
    			{
    				  $iTimeWindow = $iTimeWindow * 3;
    			}
    			else if($infoc->OTPChangeTime==60)
    			{
    					 $iTimeWindow = $iTimeWindow;
    			}
    			else
    			{
    					return "300";
    			}
    	
           
    			 
    			
    			for($i=-1 * $iTimeWindow;$i<=$iTimeWindow ;$i++)
            	 {
            	  
            		if( $i + $lTotalMovingValue <= $infoc->LastLoginTotalMovingValue)
                    {
                            continue;
                    }
                    
                   
     
    				if( $si->get_base_time_password($sg->bytetoString($infoc->Key),$activeInfo,$i+ $infoc->TokenTimeOffsetMinute + $lTotalMovingValue,6)==$password)
                    {
                            $infoc->TokenTimeOffsetMinute =$infoc->TokenTimeOffsetMinute + $i;
                            $infoc->LastLoginTotalMovingValue = $lTotalMovingValue;
                                                                         
                            $pResultCB=$this->OCRA_HOTP_GetNewCB($sninfo, $infoc);
    												 
                            return $pResultCB;
                    }
     
            
    			}

        return "0";	
    }

	function OCRA_time_based_otp_syn($sninfo,$activeInfo,$password) {

	   if($this->OCRA_CheckCB_v0($sninfo)!=1)
		{
			return "-1";
		}
		
		$infoc=new tokeninfoc();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();
		
		
		$lTotalMovingValue =$si->GetTotalMovingValueOfNow($infoc->OTPChangeTime);
 
        $iLastTimebettwenDays = $si->KingKey_HOTP_GetSpaceDayBetweenLastTime($lTotalMovingValue - $infoc->LastchangellTotalMovingValue, $infoc->OTPChangeTime );
 
        // < 1¸öÔÂ
        if($iLastTimebettwenDays <= 30)
        {
                $iTimeWindow = 90;
        }         
        else // 12¸öÔÂÒÔÉÏ
        {
                $iTimeWindow = 120;
        }

	
			if($infoc->OTPChangeTime==30)
			{
				$iTimeWindow = $iTimeWindow * 2;
			}
			elseif ($infoc->OTPChangeTime==20)
			{
				  $iTimeWindow = $iTimeWindow * 3;
			}
			else if($infoc->OTPChangeTime==60)
			{
					 $iTimeWindow = $iTimeWindow;
			}
			else
			{
					return "300";
			}
	
       

        	/*
        	 for($i=-1 * $iTimeWindow + $infoc->TokenTimeOffsetMinute + $lTotalMovingValue;$i<$iTimeWindow + $infoc->TokenTimeOffsetMinute + $lTotalMovingValue ;$i++)
        	 {
        	  
        		if( $i <= $infoc->LastLoginTotalMovingValue)
                {
                        continue;
                }
                
               
 
				if( $si->get_base_time_password($sg->bytetoString($infoc->Key),$activeInfo,$i,6)==$password)
                {
                        $infoc->TokenTimeOffsetMinute =$lTotalMovingValue- $i;
                        $infoc->LastLoginTotalMovingValue = $i;
                                                                     
                        $pResultCB=$this->OCRA_HOTP_GetNewCB($sninfo, $infoc);
												 
                        return $pResultCB;
                }
         
			}
			*/
			
			for($i=-1 * $iTimeWindow;$i<=$iTimeWindow ;$i++)
        	 {
        	  
        		if( $i + $lTotalMovingValue <= $infoc->LastLoginTotalMovingValue)
                {
                        continue;
                }
                
               
 
				if( $si->get_base_time_password($sg->bytetoString($infoc->Key),$activeInfo,$i+ $infoc->TokenTimeOffsetMinute + $lTotalMovingValue,6)==$password)
                {
                        $infoc->TokenTimeOffsetMinute =$infoc->TokenTimeOffsetMinute + $i;
                        $infoc->LastLoginTotalMovingValue = $lTotalMovingValue;
                                                                     
                        $pResultCB=$this->OCRA_HOTP_GetNewCB($sninfo, $infoc);
												 
                        return $pResultCB;
                }
 
        
			}

       return "0";	
    }

    function OCRA_Get_Time_Based_OTPs($sninfo,$activeInfo){
	
        if($this->OCRA_CheckCB_v0($sninfo)!=1)
		{
			return "-1";
		}
		
		$infoc=new tokeninfoc();
		
		$infoc=$this->OCRA_HOTP_GetInfoFromCB($sninfo);
		
		$si=new seamoonapi();
		$sg=new stringchange();
		
		
		$lTotalMovingValue =$si->GetTotalMovingValueOfNow($infoc->OTPChangeTime);
 
        
         $iTimeWindow = 10;
       
         
	
			if($infoc->OTPChangeTime==30)
			{
				$iTimeWindow = $iTimeWindow * 2;
			}
			elseif ($infoc->OTPChangeTime==20)
			{
				  $iTimeWindow = $iTimeWindow * 3;
			}
			else if($infoc->OTPChangeTime==60)
			{
					 $iTimeWindow = $iTimeWindow;
			}
			else
			{
					return "300";
			}
	
			$str="";

        	 for($i=-1 * $iTimeWindow + $infoc->TokenTimeOffsetMinute + $lTotalMovingValue;$i<=$iTimeWindow + $infoc->TokenTimeOffsetMinute + $lTotalMovingValue ;$i++)
        	 {          
	
				$str= $str. $si->get_base_time_password($sg->bytetoString($infoc->Key),$activeInfo,$i,6) . "," ;
        
			}

		if(strlen($str)>1)
		{
			$str=substr($str,0,strlen($str)-1);
		}
       return $str;	
    }

}

/*
| ---------------------------
| Class seamoonsea
| ---------------------------
*/

class seamoonsea {
 	
    function checkcb($pcb) {
 		
        if(strlen($pcb)!=400)
 		{
 			return -1;
 		}
 		
 		$cMd5InputStr="ShenzhenSeamoonCommunicationTechnologyCo,Ltd,20050328.88888888889999999999";
 		$cMd5InputStr=$cMd5InputStr . substr($pcb,0,49) . substr($pcb,81,strlen($pcb));
 		
 		if(substr($pcb,49,32)==strtoupper(md5($cMd5InputStr))){ 		
 			return 1;
 		}
 		else
 		{ 		
 			return -1; 		
 		}

 	}

 	function checkpasswordsea($pcb,$password) {
 		 
 		if ($this->checkcb($pcb)!=1 )
 		{
 			reutrn -1;	
 		}
 		
 		$pResultCB=array();
 		
 		for($tempk=0;$tempk<strlen($pcb);$tempk++)
 		{
 			$pResultCB[$tempk]= substr($pcb,$tempk,1);	 			 
 		}
 		 
 		$pucKey;
   	    $InitDayTime=new otpdatetime();
		$LastDayTime=new otpdatetime();
		$stNow=new otpdatetime();
		$iMinuteOffSet;
		$iSecondOffSet;
		$ucPswType;
		$ucLastLoninState;
		$ucLastPsw;
		$iPswChangeTime;
		$iPswActiveTime;
		$ucPswActiveType;
 		
 		$iKeyLen=(ord(substr($pcb,91,1))-48) * 100 + (ord(substr($pcb,92,1))-48)* 10 + (ord(substr($pcb,93,1))-48); 
 		for($i=0;$i<5;$i++)
 		{
 			$pucKey[$i]=substr($pcb,94+$i,1);
 		}
 		for($i=0;$i<$iKeyLen-5;$i++)
 		{
 			$pucKey[$i+5 ]=substr($pcb,124+$i,1);
 		}
 		 
 		 $stNow->year=date("Y");  
 		 $stNow->month=date("m") ;
 		 $stNow->day=date("d");
 		 $stNow->hour= date("H")  ;
 		 $stNow->minute=date("i") ;
 
 		
 		 $InitDayTime->year=(ord(substr($pcb,81,1))-48) * 1000 + (ord(substr($pcb,82,1))-48) * 100 + (ord(substr($pcb,89,1))-48) * 10 + (ord(substr($pcb,90,1))-48);  
 		 $InitDayTime->month=(ord(substr($pcb,112,1))-48) * 10 + (ord(substr($pcb,113,1))-48)  ;
 		 $InitDayTime->day=(ord(substr($pcb,116,1))-48) * 10 + (ord(substr($pcb,117,1))-48)  ;
 		 $InitDayTime->hour=(ord(substr($pcb,85,1))-48) * 10 + (ord(substr($pcb,86,1))-48)  ;
 		 $InitDayTime->minute=(ord(substr($pcb,108,1))-48) * 10 + (ord(substr($pcb,109,1))-48);
 		 $InitDayTime->second=(ord(substr($pcb,120,1))-48) * 10 + (ord(substr($pcb,121,1))-48);
 		 
 		 $LastDayTime->year=(ord(substr($pcb,110,1))-48) * 1000 + (ord(substr($pcb,111,1))-48) * 100 + (ord(substr($pcb,114,1))-48) * 10 + (ord(substr($pcb,115,1))-48);  
 		 $LastDayTime->month=(ord(substr($pcb,118,1))-48) * 10 + (ord(substr($pcb,119,1))-48)  ;
 		 $LastDayTime->day=(ord(substr($pcb,87,1))-48) * 10 + (ord(substr($pcb,88,1))-48)  ;
 		 $LastDayTime->hour=(ord(substr($pcb,106,1))-48) * 10 + (ord(substr($pcb,107,1))-48)  ;
 		 $LastDayTime->minute=(ord(substr($pcb,83,1))-48) * 10 + (ord(substr($pcb,84,1))-48);
 		 $LastDayTime->second=(ord(substr($pcb,122,1))-48) * 10 + (ord(substr($pcb,123,1))-48);

 		 $iMinuteOffSet=(ord(substr($pcb,100,1))-48) * 10 + (ord(substr($pcb,101,1))-48) * 10 + (ord(substr($pcb,102,1))-48);  
 		 
 		 if( substr($pcb,99,1)=="2")
 		 {
 		 	$iMinuteOffSet=$iMinuteOffSet * -1;
 			}
 			
 			$iSecondOffSet= (ord(substr($pcb,104,1))-48) * 10 + (ord(substr($pcb,105,1))-48);  

 			if(substr($pcb,99,1)=="2")
 		  {
 		 		$iSecondOffSet=$iSecondOffSet * -1;
 			}
 			
 			$ucPswType=ord(substr($pcb,224,1))-48;
 			$ucLastLoninState=ord(substr($pcb,386,1))-48;
 			
 			$ucLastPsw[0]= ord(substr($pcb,225,1));
 			$ucLastPsw[1]= ord(substr($pcb,226,1));
 			$ucLastPsw[2]= ord(substr($pcb,393,1));
 			$ucLastPsw[3]= ord(substr($pcb,394,1));
 			$ucLastPsw[4]= ord(substr($pcb,395,1));
 			$ucLastPsw[5]= ord(substr($pcb,396,1));
 			$ucLastPsw[6]=0;
 			
 			$iPswChangeTime=(ord(substr($pcb,387,1))-48) * 1000 + (ord(substr($pcb,388,1))-48) * 100 + (ord(substr($pcb,389,1))-48) * 10 + (ord(substr($pcb,390,1))-48);  
 			$iPswActiveTime= (ord(substr($pcb,391,1))-48) * 10 +  (ord(substr($pcb,392,1))-48);
 			$ucPswActiveType=ord(substr($pcb,397,1))-48; 
 			 
 			 
 		
			 $nowtimecount=(int)((time()-mktime($InitDayTime->hour,$InitDayTime->minute,$InitDayTime->second,$InitDayTime->month,$InitDayTime->day,$InitDayTime->year))/60);
			 $lasttimecount=(int)(
			 mktime($LastDayTime->hour,$LastDayTime->minute,$LastDayTime->second,$LastDayTime->month,$LastDayTime->day,$LastDayTime->year)
			 /60-mktime($InitDayTime->hour,$InitDayTime->minute,$InitDayTime->second,$InitDayTime->month,$InitDayTime->day,$InitDayTime->year)/60);
			 
			 
			 
			 $iTimeWindow=(int)($lasttimecount/(60*24));
			 
			 if($iTimeWindow<60)
			 {
			 	  $iTimeWindow=5;
			 }
			 else if($iTimeWindow>=60 && $iTimeWindow<360)
			 {
			 	$iTimeWindow=30;
			}
			else
			{
				$iTimeWindow=60;
			}
			
			
			if($iPswChangeTime!=60)
			{
				return -1;
			}
			
			for($i=-1*$iTimeWindow;$i<=$iTimeWindow;$i++)
			{
				if (($nowtimecount + $iMinuteOffSet + $i) <=($lasttimecount + $iMinuteOffSet)) {
                         
                        continue;
                    }
                             
             if( $this->SMGetPsw($pucKey,$nowtimecount + $iMinuteOffSet + $i)==$password)
             {
             	   
             	   				$pResultCB[110] =(int) ($stNow->year / 1000 );
                        $pResultCB[111] =(int) (($stNow->year % 1000) / 100 );
                        $pResultCB[114] =(int)(($stNow->year % 100) / 10 );
                        $pResultCB[115] =(int)((($stNow->year % 10) ));

                        $pResultCB[118] =(int)( $stNow->month / 10);
                        $pResultCB[119] =(int)( ($stNow->month % 10) );

                        $pResultCB[87] = (int)($stNow->day / 10);
                        $pResultCB[88] = (int)(($stNow->day % 10) );

                        $pResultCB[106] = (int) ($stNow->hour / 10 );
                        $pResultCB[107] =(int)( ($stNow->hour % 10));

                        $pResultCB[83] =(int)( $stNow->minute / 10);
                        $pResultCB[84] =(int)(($stNow->minute % 10)) ;

                        $pResultCB[122] = '0';
                        $pResultCB[123] = '0';

											

                        //·ÖÆ«ÒÆÁ¿
                        $pResultCB[100] = (int) (($i + $iMinuteOffSet) / 100);
                        $pResultCB[101] = (int) ((($i + $iMinuteOffSet) % 100) / 10);
                        $pResultCB[102] = (int) (($i + $iMinuteOffSet) % 10);

                        if ($i + $iMinuteOffSet > 0) {
                            $pResultCB[99] = '1';
                        } else {
                            $pResultCB[99] = '2';
                        }

                        //ÃëÆ«ÒÆÁ¿
                        for ($i = 103; $i < 106; $i++) {
                            $pResultCB[$i] = '0';
                        }
                        
                        $pResultCB[386] = '1';
                   			
                   			$strSeamoon="ShenzhenSeamoonCommunicationTechnologyCo,Ltd,20050328.88888888889999999999";
                   			
                        $cMd5InputStr = $strSeamoon;
                                                                       
                        for ($i = 0; $i < 49; $i++) {
                            $cMd5InputStr = $cMd5InputStr . ($pResultCB[$i]);
                        }
                      
                        for ($i = 0; $i < 319; $i++) {
                            $cMd5InputStr = $cMd5InputStr . ($pResultCB[81 +$i]);
                        }

                        
                        
                        $cMd5ResultStr =strtoupper(md5($cMd5InputStr));
                         
                        for ($i = 0; $i < 32; $i++) {
                            $pResultCB[49 + $i] = substr($cMd5ResultStr,$i,1) ;
                        }
 
 												$returnstr="";
 				
												for($i=0;$i<400;$i++)
												{
													$returnstr= $returnstr . $pResultCB[$i];
													
												}
												 
                        return $returnstr; 
             }               
				
			}

 		return "0";	 
 	}
 	
 	
 	function passwordsynsea($pcb,$password){
 		 
 		if ($this->checkcb($pcb)!=1 )
 		{
 			reutrn -1;	
 		}
 		
 		$pResultCB=array();
 		
 		for($tempk=0;$tempk<strlen($pcb);$tempk++)
 		{
 			$pResultCB[$tempk]= substr($pcb,$tempk,1);	 			 
 		}
 		 
 		$pucKey;
   	    $InitDayTime=new otpdatetime();
		$LastDayTime=new otpdatetime();
		$stNow=new otpdatetime();
		$iMinuteOffSet;
		$iSecondOffSet;
		$ucPswType;
		$ucLastLoninState;
		$ucLastPsw;
		$iPswChangeTime;
		$iPswActiveTime;
		$ucPswActiveType;
 		
 		$iKeyLen=(ord(substr($pcb,91,1))-48) * 100 + (ord(substr($pcb,92,1))-48)* 10 + (ord(substr($pcb,93,1))-48); 
 		for($i=0;$i<5;$i++)
 		{
 			$pucKey[$i]=substr($pcb,94+$i,1);
 		}
 		for($i=0;$i<$iKeyLen-5;$i++)
 		{
 			$pucKey[$i+5 ]=substr($pcb,124+$i,1);
 		}
 		 
 		 $stNow->year=date("Y");  
 		 $stNow->month=date("m") ;
 		 $stNow->day=date("d");
 		 $stNow->hour= date("H")  ;
 		 $stNow->minute=date("i") ;
 
 		
 		 $InitDayTime->year=(ord(substr($pcb,81,1))-48) * 1000 + (ord(substr($pcb,82,1))-48) * 100 + (ord(substr($pcb,89,1))-48) * 10 + (ord(substr($pcb,90,1))-48);  
 		 $InitDayTime->month=(ord(substr($pcb,112,1))-48) * 10 + (ord(substr($pcb,113,1))-48)  ;
 		 $InitDayTime->day=(ord(substr($pcb,116,1))-48) * 10 + (ord(substr($pcb,117,1))-48)  ;
 		 $InitDayTime->hour=(ord(substr($pcb,85,1))-48) * 10 + (ord(substr($pcb,86,1))-48)  ;
 		 $InitDayTime->minute=(ord(substr($pcb,108,1))-48) * 10 + (ord(substr($pcb,109,1))-48);
 		 $InitDayTime->second=(ord(substr($pcb,120,1))-48) * 10 + (ord(substr($pcb,121,1))-48);
 		 
 		 $LastDayTime->year=(ord(substr($pcb,110,1))-48) * 1000 + (ord(substr($pcb,111,1))-48) * 100 + (ord(substr($pcb,114,1))-48) * 10 + (ord(substr($pcb,115,1))-48);  
 		 $LastDayTime->month=(ord(substr($pcb,118,1))-48) * 10 + (ord(substr($pcb,119,1))-48)  ;
 		 $LastDayTime->day=(ord(substr($pcb,87,1))-48) * 10 + (ord(substr($pcb,88,1))-48)  ;
 		 $LastDayTime->hour=(ord(substr($pcb,106,1))-48) * 10 + (ord(substr($pcb,107,1))-48)  ;
 		 $LastDayTime->minute=(ord(substr($pcb,83,1))-48) * 10 + (ord(substr($pcb,84,1))-48);
 		 $LastDayTime->second=(ord(substr($pcb,122,1))-48) * 10 + (ord(substr($pcb,123,1))-48);

 		 $iMinuteOffSet=(ord(substr($pcb,100,1))-48) * 10 + (ord(substr($pcb,101,1))-48) * 10 + (ord(substr($pcb,102,1))-48);  
 		 
 		 if( substr($pcb,99,1)=="2")
 		 {
 		 	$iMinuteOffSet=$iMinuteOffSet * -1;
 			}
 			
 			$iSecondOffSet= (ord(substr($pcb,104,1))-48) * 10 + (ord(substr($pcb,105,1))-48);  

 			if(substr($pcb,99,1)=="2")
 		  {
 		 		$iSecondOffSet=$iSecondOffSet * -1;
 			}
 			
 			$ucPswType=ord(substr($pcb,224,1))-48;
 			$ucLastLoninState=ord(substr($pcb,386,1))-48;
 			
 			$ucLastPsw[0]= ord(substr($pcb,225,1));
 			$ucLastPsw[1]= ord(substr($pcb,226,1));
 			$ucLastPsw[2]= ord(substr($pcb,393,1));
 			$ucLastPsw[3]= ord(substr($pcb,394,1));
 			$ucLastPsw[4]= ord(substr($pcb,395,1));
 			$ucLastPsw[5]= ord(substr($pcb,396,1));
 			$ucLastPsw[6]=0;
 			
 			$iPswChangeTime=(ord(substr($pcb,387,1))-48) * 1000 + (ord(substr($pcb,388,1))-48) * 100 + (ord(substr($pcb,389,1))-48) * 10 + (ord(substr($pcb,390,1))-48);  
 			$iPswActiveTime= (ord(substr($pcb,391,1))-48) * 10 +  (ord(substr($pcb,392,1))-48);
 			$ucPswActiveType=ord(substr($pcb,397,1))-48; 
 			 
 			 
 		
			 $nowtimecount=(int)((time()-mktime($InitDayTime->hour,$InitDayTime->minute,$InitDayTime->second,$InitDayTime->month,$InitDayTime->day,$InitDayTime->year))/60);
			 $lasttimecount=(int)(
			 mktime($LastDayTime->hour,$LastDayTime->minute,$LastDayTime->second,$LastDayTime->month,$LastDayTime->day,$LastDayTime->year)
			 /60-mktime($InitDayTime->hour,$InitDayTime->minute,$InitDayTime->second,$InitDayTime->month,$InitDayTime->day,$InitDayTime->year)/60);
			 
			 
			 
			 $iTimeWindow=90;
			 
			 
			
			
			if($iPswChangeTime!=60)
			{
				return -1;
			}
			
			for($i=-1*$iTimeWindow;$i<=$iTimeWindow;$i++)
			{
				if (($nowtimecount + $iMinuteOffSet + $i) <=($lasttimecount + $iMinuteOffSet)) {
                         
                        continue;
                    }
                             
             if( $this->SMGetPsw($pucKey,$nowtimecount + $iMinuteOffSet + $i)==$password)
             {
             	   
             	   				$pResultCB[110] =(int) ($stNow->year / 1000 );
                        $pResultCB[111] =(int) (($stNow->year % 1000) / 100 );
                        $pResultCB[114] =(int)(($stNow->year % 100) / 10 );
                        $pResultCB[115] =(int)((($stNow->year % 10) ));

                        $pResultCB[118] =(int)( $stNow->month / 10);
                        $pResultCB[119] =(int)( ($stNow->month % 10) );

                        $pResultCB[87] = (int)($stNow->day / 10);
                        $pResultCB[88] = (int)(($stNow->day % 10) );

                        $pResultCB[106] = (int) ($stNow->hour / 10 );
                        $pResultCB[107] =(int)( ($stNow->hour % 10));

                        $pResultCB[83] =(int)( $stNow->minute / 10);
                        $pResultCB[84] =(int)(($stNow->minute % 10)) ;

                        $pResultCB[122] = '0';
                        $pResultCB[123] = '0';

											

                        //·ÖÆ«ÒÆÁ¿
                        $pResultCB[100] = (int) (($i + $iMinuteOffSet) / 100);
                        $pResultCB[101] = (int) ((($i + $iMinuteOffSet) % 100) / 10);
                        $pResultCB[102] = (int) (($i + $iMinuteOffSet) % 10);

                        if ($i + $iMinuteOffSet > 0) {
                            $pResultCB[99] = '1';
                        } else {
                            $pResultCB[99] = '2';
                        }

                        //ÃëÆ«ÒÆÁ¿
                        for ($i = 103; $i < 106; $i++) {
                            $pResultCB[$i] = '0';
                        }
                        
                        $pResultCB[386] = '1';
                   			
                   			$strSeamoon="ShenzhenSeamoonCommunicationTechnologyCo,Ltd,20050328.88888888889999999999";
                   			
                        $cMd5InputStr = $strSeamoon;
                                                                       
                        for ($i = 0; $i < 49; $i++) {
                            $cMd5InputStr = $cMd5InputStr . ($pResultCB[$i]);
                        }
                      
                        for ($i = 0; $i < 319; $i++) {
                            $cMd5InputStr = $cMd5InputStr . ($pResultCB[81 +$i]);
                        }

                        
                        
                        $cMd5ResultStr =strtoupper(md5($cMd5InputStr));
                         
                        for ($i = 0; $i < 32; $i++) {
                            $pResultCB[49 + $i] = substr($cMd5ResultStr,$i,1) ;
                        }
 
 												$returnstr="";
 				
												for($i=0;$i<400;$i++)
												{
													$returnstr= $returnstr . $pResultCB[$i];
													
												}
												 
                        return $returnstr; 
             }               
				
			}

 		  	return "0";	 
 	}
 	
 	function SMGetPsw($key,$iMinutes) {
    	$i=0;
    	 
    	for($i=0;$i<count($key);$i++)
    	{
    		$shain[$i]= ord($key[$i]);
    	}
    	
    	$strSeamoon = "ShenzhenSeamoon20050328";
    	
    	for($j=0;$j<strlen($strSeamoon);$j++)
    	{
    		$shain[$i]= ord(substr($strSeamoon,$j,1));
    		$i++;
    		
        }
   
      $shain[$i]= (int)(($iMinutes & 0xFF000000) >> 24);  
      $shain[$i+1]= (int)(($iMinutes & 0x00FF0000) >> 16);
      $shain[$i+2]= (int)(($iMinutes & 0x0000FF00) >> 8);
      $shain[$i+3]= (int)(($iMinutes & 0x000000FF));
      
      $i=$i+4;
      $shain[$i]=0;
      
      $shain2="";
      for($j=0;$j<=$i;$j++)
      {
      	$shain2=$shain2 . chr($shain[$j]);
      	  	 
      }   
     
     $re= sha1($shain2);
      
      $re=strtoupper($re);
     
      
      $sg=new stringchange();
      
      $bytere=$sg->hexStringToByte2($re);
      
     return $this->SMGetpPswFromSha("SEAMOON20050328",1,$bytere);
       
    }

    function SMGetpPswFromSha($pSecret, $ucKeyType, $ucMessage_Digest) {
       
        $i=0;
        $ch='1';
        $ulTmpSum=array ();
        $ulTmpSumLen=0;
        $psw="";
        $Message_Digest =array ();

        $ucMessage_Digest2=array ();
      
    	for ($kk=0;$kk<20;$kk++)
    	{

        $ucMessage_Digest2[$kk]=$ucMessage_Digest[$kk]& 0x0ff;
    	}

        

        for ($i = 0; $i < 20; $i++) {
            $Message_Digest[$i] = $ucMessage_Digest2[$i];
             
        }


        switch ($ucKeyType) {
        case 0:
            for ($i = 0; $i < 4; $i++) {
                $ulTmpSum[$i] = $Message_Digest[$i]
                              + $Message_Digest[4 + $i]
                              + $Message_Digest[8 + $i]
                              + $Message_Digest[12 + $i]
                              + $Message_Digest[16 + $i];
            }

            $ulTmpSumLen = 4;

            break;

        case 1:
        case 2:
            for ($i = 0; $i < 4; $i++) {
                $ulTmpSum[$i] = $Message_Digest[$i]
                              + $Message_Digest[6 + $i]
                              + $Message_Digest[12 + $i];
            }

            $ulTmpSum[4] = $Message_Digest[16] + $Message_Digest[17];
            $ulTmpSum[5] = $Message_Digest[18] + $Message_Digest[19];

            $ulTmpSumLen = 6;

            break;

        case 3:
        case 4:
            for ($i = 0; $i < 8; $i++) {
                $ulTmpSum[$i] = $Message_Digest[$i]
                              + $Message_Digest[8 + $i]
                              + $Message_Digest[16]
                              + $Message_Digest[17]
                              + $Message_Digest[18]
                              + $Message_Digest[19];
            }

            $ulTmpSumLen = 8;

            break;

        default:

            // printf("\r\nERROR");
            return "";
        }
    
        for ($i = 0; $i < $ulTmpSumLen; $i++) {
            switch ($ucKeyType) {
            case 1:
            case 3:
            		
                switch ((int) ($ulTmpSum[$i] % 10)) {
                case 0:
                    $ch = '0';
                    break;

                case 1:
                    $ch = '1';
                    break;

                case 2:
                    $ch = '2';
                    break;

                case 3:
                    $ch = '3';
                   
                    break;

                case 4:
                    $ch = '4';
                   
                    break;

                case 5:
                    $ch = '5';
                    
                    break;

                case 6:
                    $ch = '6';
                    break;

                case 7:
                    $ch = '7';
                    break;

                case 8:
                    $ch = '8';
                    break;

                case 9:
                    $ch = '9';
                    break;

                default:
                    $ch = 'Z';
                    break;
                }

                break;

            default:
                switch ((int) ($ulTmpSum[$i] % 28)) {
                case 0:
                    $ch = 'A';
                    break;

                case 1:
                    $ch = 'B';
                    break;

                case 2:
                    $ch = 'C';
                    break;

                case 3:
                    $ch = 'D';
                    break;

                case 4:
                    $ch = 'E';
                    break;

                case 5:
                    $ch = 'F';
                    break;

                case 6:
                    $ch = 'G';
                    break;

                case 7:
                    $ch = 'H';
                    break;

                case 8:
                    $ch = 'J';
                    break;

                case 9:
                    $ch = 'K';
                    break;

                case 10:
                    $ch = 'L';
                    break;

                case 11:
                    $ch = 'M';
                    break;

                case 12:
                    $ch = 'N';
                    break;

                case 13:
                    $ch = 'P';
                    break;

                case 14:
                    $ch = 'Q';
                    break;

                case 15:
                    $ch = 'R';
                    break;

                case 16:
                    $ch = 'S';
                    break;

                case 17:
                    $ch = 'T';
                    break;

                case 18:
                    $ch = 'W';
                    break;

                case 19:
                    $ch = 'X';
                    break;

                case 20:
                    $ch = 'Y';
                    break;

                case 21:
                    $ch = '3';
                    break;

                case 22:
                    $ch = '4';
                    break;

                case 23:
                    $ch = '5';
                    break;

                case 24:
                    $ch = '6';
                    break;

                case 25:
                    $ch = '7';
                    break;

                case 26:
                    $ch = '8';
                    break;

                case 27:
                    $ch = '9';

                    break;

                default:
                    $ch = 'Z';
                    break;
                }

                break;
            }

            $psw =$psw . $ch;
        }


        return $psw;
        
    }
 	
}
?>
