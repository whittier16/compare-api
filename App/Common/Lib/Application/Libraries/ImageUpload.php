<?php
namespace App\Common\Lib\Application\Libraries;

use Phalcon\DI\Injectable,
	Imagine\Imagick\Imagine;

class ImageUpload extends Injectable{
	
	public $uploadPath; 
	
    public function __construct() {
    	$environment = $this->di->getConfig()->application->environment;
        $this->uploadPath = $this->di->getConfig()->application->uploadPath->$environment;
    }
    
    public function save($image = null, $options = array()) {
        $opts = array_merge(array(
            'prefix'        => '',
            'basename'      => uniqid(),
            'uploadpath'    => 'uncategorized',
            'quality'       => 85
        ), $options);
        
        // Image processing library
        $imagine = new Imagine();
        try {
            // Load image data
            $img = $imagine->load($image);
            $imgInfo = $img->getImagick()->identifyImage();
            $format = explode(' ', $imgInfo['format']);
            $type = strtolower(reset($format));
            
            // Uploaded file is an image
            if ($extension = $this->fileExtentionFromType($type, true)) {
                
                // Create roman (alpha-numeric, _) slug of company name, crude but effective
                $filename = $opts['prefix'] . $this->safeTransliterate($opts['basename']) . $extension;
                $filePath = $this->uploadPath . $opts['uploadpath'] . $filename;
            
                $img_max_width = $opts['max_width'];
                $img_max_height = $opts['max_height'];
            
                // Get image dimensions from Imagick handle
                $imgSize = $img->getSize();
                $width = $imgSize->getWidth();
                $height = $imgSize->getHeight();
            
                // Is image larger than max values?
                if (($width > $img_max_width) || ($height > $img_max_height)) {
                    if (($width > $img_max_width) && ($height > $img_max_height)) {
                        // width and height is larger
                        if ($width > $height) {
                            try {
                                $img = $img->resize($img->getSize()->widen($img_max_width));
                            } catch (Exception $e) {
                                die($e->getMessage());
                            }
                        } else {
                            try {
                                $img = $img->resize($img->getSize()->heighten($img_max_height));
                            } catch (Exception $e) {
                                die($e->getMessage());
                            }
                        }
                    
                    } else if ($width > $img_max_width) {
                        // width is larger
                        try {
                            $img = $img->resize($img->getSize()->widen($img_max_width));
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        // height is larger
                        try {
                            $img = $img->resize($img->getSize()->heighten($img_max_height));
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    }
                }
            
                // Save file
                try {
                    echo $filePath;
                    $img->save($filePath, array('quality' => $opts['quality']));
                
                    // Populate company_log field with absolute URL
                    return $opts['uploadpath'] . $filename;
                } catch (Exception $e) {
                    die($e->getMessage());
                    unset($data['company_logo']);
                }
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function fileExtentionFromType($type = null, $dot = false) {
        $types = array(
            'gif' => 'gif',
            'jpg' => 'jpg',
            'jpeg' => 'jpg',
            'png' => 'png',
            'tif' => 'tif',
            'bmp' => 'bmp'
        );
        
        $extension = $types[$type];
        
        if ($dot) {
            $extension = '.'.$extension;
        }
        
        return $extension;
    }
    
    public function safeTransliterate($text) {
    	//if available, this function uses PHP5.4's transliterate, which is capable of converting arabic, hebrew, greek,
    	//chinese, japanese and more into ASCII! however, we use our manual (and crude) fallback *first* instead because
    	//we will take the liberty of transliterating some things into more readable ASCII-friendly forms,
    	//e.g. "100℃" > "100degc" instead of "100oc"
    
    			/* manual transliteration list:
    			 -------------------------------------------------------------------------------------------------------------- */
    	/* this list is supposed to be practical, not comprehensive, representing:
    	 1. the most common accents and special letters that get typed, and
    	2. the most practical transliterations for readability;
    
    	given that I know nothing of other languages, I will need your assistance to improve this list,
    	mail kroc@camendesign.com with help and suggestions.
    
    	this data was produced with the help of:
    	http://www.unicode.org/charts/normalization/
    	http://www.yuiblog.com/sandbox/yui/3.3.0pr3/api/text-data-accentfold.js.html
    	http://www.utf8-chartable.de/
    	*/
    	static $translit = array (
    	'a'	=> '/[ÀÁÂẦẤẪẨÃĀĂẰẮẴȦẲǠẢÅÅǺǍȀȂẠẬẶḀĄẚàáâầấẫẩãāăằắẵẳȧǡảåǻǎȁȃạậặḁą]/u',
    	'b'	=> '/[ḂḄḆḃḅḇ]/u',			'c'	=> '/[ÇĆĈĊČḈçćĉċčḉ]/u',
    	'd'	=> '/[ÐĎḊḌḎḐḒďḋḍḏḑḓð]/u',
    	'e'	=> '/[ÈËĒĔĖĘĚȄȆȨḔḖḘḚḜẸẺẼẾỀỂỄỆèëēĕėęěȅȇȩḕḗḙḛḝẹẻẽếềểễệ]/u',
    	'f'	=> '/[Ḟḟ]/u',				'g'	=> '/[ĜĞĠĢǦǴḠĝğġģǧǵḡ]/u',
    	'h'	=> '/[ĤȞḢḤḦḨḪĥȟḣḥḧḩḫẖ]/u',		'i'	=> '/[ÌÏĨĪĬĮİǏȈȊḬḮỈỊiìïĩīĭįǐȉȋḭḯỉị]/u',
    	'j'	=> '/[Ĵĵǰ]/u',				'k'	=> '/[ĶǨḰḲḴKķǩḱḳḵ]/u',
    	'l'	=> '/[ĹĻĽĿḶḸḺḼĺļľŀḷḹḻḽ]/u',		'm'	=> '/[ḾṀṂḿṁṃ]/u',
    	'n'	=> '/[ÑŃŅŇǸṄṆṈṊñńņňǹṅṇṉṋ]/u',
    	'o'	=> '/[ÒÖŌŎŐƠǑǪǬȌȎȪȬȮȰṌṎṐṒỌỎỐỒỔỖỘỚỜỞỠỢØǾòöōŏőơǒǫǭȍȏȫȭȯȱṍṏṑṓọỏốồổỗộớờởỡợøǿ]/u',
    	'p'	=> '/[ṔṖṕṗ]/u',				'r'	=> '/[ŔŖŘȐȒṘṚṜṞŕŗřȑȓṙṛṝṟ]/u',
    	's'	=> '/[ŚŜŞŠȘṠṢṤṦṨſśŝşšșṡṣṥṧṩ]/u',	'ss'	=> '/[ß]/u',
    	't'	=> '/[ŢŤȚṪṬṮṰţťțṫṭṯṱẗ]/u',		'th'	=> '/[Þþ]/u',
    	'u'	=> '/[ÙŨŪŬŮŰŲƯǓȔȖṲṴṶṸṺỤỦỨỪỬỮỰùũūŭůűųưǔȕȗṳṵṷṹṻụủứừửữựµ]/u',
    	'v'	=> '/[ṼṾṽṿ]/u',				'w'	=> '/[ŴẀẂẄẆẈŵẁẃẅẇẉẘ]/u',
    	'x'	=> '/[ẊẌẋẍ×]/u',			'y'	=> '/[ÝŶŸȲẎỲỴỶỸýÿŷȳẏẙỳỵỷỹ]/u',
    	'z'	=> '/[ŹŻŽẐẒẔźżžẑẓẕ]/u',
    	//combined letters and ligatures:
    	'ae'	=> '/[ÄǞÆǼǢäǟæǽǣ]/u',			'oe'	=> '/[Œœ]/u',
    	'dz'	=> '/[ǄǅǱǲǆǳ]/u',
    	'ff'	=> '/[ﬀ]/u',	'fi'	=> '/[ﬃﬁ]/u',	'ffl'	=> '/[ﬄﬂ]/u',
    	'ij'	=> '/[Ĳĳ]/u',	'lj'	=> '/[Ǉǈǉ]/u',	'nj'	=> '/[Ǌǋǌ]/u',
    	'st'	=> '/[ﬅﬆ]/u',	'ue'	=> '/[ÜǕǗǙǛüǖǘǚǜ]/u',
    	//currencies:
    	'eur'   => '/[€]/u',	'cents'	=> '/[¢]/u',	'lira'	=> '/[₤]/u',	'dollars' => '/[$]/u',
    	'won'	=> '/[₩]/u',	'rs'	=> '/[₨]/u',	'yen'	=> '/[¥]/u',	'pounds'  => '/[£]/u',
    	'pts'	=> '/[₧]/u',
    	//misc:
    	'degc'	=> '/[℃]/u',	'degf'  => '/[℉]/u',
    	'no'	=> '/[№]/u',	'tm'	=> '/[™]/u'
    			);
    			//do the manual transliteration first
    			$text = preg_replace (array_values ($translit), array_keys ($translit), $text);
    
    			//flatten the text down to just a-z0-9 and dash, with underscores instead of spaces
    			$text = preg_replace (
    					//remove punctuation	//replace non a-z	//deduplicate	//trim underscores from start & end
    					array ('/\p{P}/u',	'/[^_a-z0-9-]/i',	'/_{2,}/',	'/^_|_$/'),
    					array ('',		'_',			'_',		''),
    
    					//attempt transliteration with PHP5.4's transliteration engine (best):
    					//(this method can handle near anything, including converting chinese and arabic letters to ASCII.
    					// requires the 'intl' extension to be enabled)
    							function_exists ('transliterator_transliterate') ? transliterator_transliterate (
    									//split unicode accents and symbols, e.g. "Å" > "A°":
    									'NFKD; '.
    									//convert everything to the Latin charset e.g. "ま" > "ma":
    									//(splitting the unicode before transliterating catches some complex cases,
    									// such as: "㏳" >NFKD> "20日" >Latin> "20ri")
    											'Latin; '.
    											//because the Latin unicode table still contains a large number of non-pure-A-Z glyphs (e.g. "œ"),
    			//convert what remains to an even stricter set of characters, the US-ASCII set:
    			//(we must do this because "Latin/US-ASCII" alone is not able to transliterate non-Latin characters
    			// such as "ま". this two-stage method also means we catch awkward characters such as:
    			// "㏀" >Latin> "kΩ" >Latin/US-ASCII> "kO")
    			'Latin/US-ASCII; '.
    			//remove the now stand-alone diacritics from the string
    			'[:Nonspacing Mark:] Remove; '.
    			//change everything to lowercase; anything non A-Z 0-9 that remains will be removed by
    			//the letter stripping above
    			'Lower',
    			$text)
    
    			//attempt transliteration with iconv: <php.net/manual/en/function.iconv.php>
    			: strtolower (function_exists ('iconv') ? str_replace (array ("'", '"', '`', '^', '~'), '', strtolower (
    			//note: results of this are different depending on iconv version,
    			//      sometimes the diacritics are written to the side e.g. "ñ" = "~n", which are removed
    			iconv ('UTF-8', 'US-ASCII//IGNORE//TRANSLIT', $text)
    			)) : $text)
    			);
    
    			//old iconv versions and certain inputs may cause a nullstring. don't allow a blank response
    			return !$text ? '_' : $text;
    }
}