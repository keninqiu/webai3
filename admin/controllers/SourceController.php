<?php

namespace app\controllers;

require_once(__DIR__ . '/../lib/simple_html_dom.php');
require_once(__DIR__ . '/../components/CurlUtil.class.php');
require_once(__DIR__ . '/../components/Logger.class.php');
require_once(__DIR__ . '/../components/TranslateUtil.class.php');
use Yii;
use app\models\Source;
use app\models\Product;
use app\models\Brand;
use app\models\SourceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\CurlUtil;
use app\components\Logger;
use app\components\TranslateUtil;
use app\managers\ProductManager;
use app\managers\ProductImageManager;
use app\managers\SettingManager;
use yii\filters\AccessControl;
/**
 * SourceController implements the CRUD actions for Source model.
 */
class SourceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],            
        ];
    }

    public function getProductFromMichaelKors($source) {
        $url = "curl '$source' -H 'Accept-Encoding: gzip, deflate, sdch, br' -H 'Accept-Language: en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Referer: https://www.google.ca/' -H 'Cookie: AMCVS_3D6068F454E7858C0A4C98A6%40AdobeOrg=1; _ga=GA1.2.1907222121.1494555480; _gid=GA1.2.354137612.1494555482; JSESSIONID=3Gb6bq9i5GdElnNTD8eyFrXLmO8Dikva6h_-qa0TgV1fOGTC1AVR!104871367; ATG_SESSION_ID=3Gb6bq9i5GdElnNTD8eyFrXLmO8Dikva6h_-qa0TgV1fOGTC1AVR!104871367!1494555209570; WLS_ROUTE=.www.h; BVImplmain_site=19826; s_campaign=MKS_Google_CA_Brand_MKO_GOO_ENGL_CA_NCA_T_E_HANDBAGS-ALL_mk_bag; s_cc=true; AMCV_3D6068F454E7858C0A4C98A6%40AdobeOrg=2121618341%7CMCIDTS%7C17299%7CMCMID%7C52436054126959534631589389205561932115%7CMCAAMLH-1495160279%7C7%7CMCAAMB-1495160279%7CNRX38WO0n5BH8Th-nqAG_A%7CMCOPTOUT-1494562679s%7CNONE%7CMCAID%7CNONE%7CMCSYNCSOP%7C411-17306; BVBRANDID=d78d0d6e-d56f-4980-a9e5-21b99b70d451; BVBRANDSID=8cf628fa-2479-4b8f-b5ce-c024127dff56; gig_hasGmid=ver2; productMerchNum=5; _gat_a4783b567b23728578c6a7d0a717c392=1; userPrefLanguage=en_CA; cookieLanguage=en_CA; dtm_pageviews=6; _uetsid=_uetcf08b709; xyz_cr_356_et_100==NaN&cr=356&et=100&ap=; mt.v=2.1688862926.1494555477916; rr_rcs=eF4FwbENgDAMBMAmFbu8hOO3gzdgjShOJAo6YH7uSnnHqRK5JhWtDwNTBYNJ0M3XjF6Dut3fc-Uu0hqEQTNT1sMcTkB-nfMRoQ; s_sq=%5B%5BB%5D%5D; gpv_pn=Home%20%3E%20WOMEN%20%3E%20HANDBAGS%20%3E%20SelmaMediumSaffianoLeatherMessenger; gpv_purl=%2Fselma-medium-saffiano-leather-messenger%2F_%2FR-CA_30T3GLMM2L; gpv_ptyp=Product%20Detail; s_nr=1494555632003-New; s_vs=1; tp=4865; s_ppv=Home%2520%253E%2520WOMEN%2520%253E%2520HANDBAGS%2520%253E%2520SelmaMediumSaffianoLeatherMessenger%2C13%2C13%2C656; RT=\"sl=3&ss=1494555476158&tt=26458&obo=0&bcn=%2F%2F36d7107f.mpstat.us%2F&sh=1494555612967%3D3%3A0%3A26458%2C1494555515675%3D2%3A0%3A23538%2C1494555498241%3D1%3A0%3A20473&dm=michaelkors.ca&si=94e4d133-576d-4158-86a8-09fda3d43d97&nu=https%3A%2F%2Fwww.michaelkors.ca%2Fselma-medium-saffiano-leather-messenger%2F_%2FR-CA_30T3GLMM2L%3Fcolor%3D1663&cl=1494555611884&ld=1494555612968\"' -H 'Connection: keep-alive' -H 'Cache-Control: max-age=0' --compressed";

        //Logger::curllog("url=".$url);
        $response = CurlUtil::raw($url);
        //$response = str_replace("");
       // Logger::curllog("response=".$response);

        $html = str_get_html($response);

        $name = "";
        $nameTag = $html->find('h1[itemprop="name"]',0);
        if($nameTag) {
            $name = $nameTag->text();
        }
       // Logger::curllog("name=".$name);

        $spec = "spec";  
        $specTag = $html->find('div[class="detail"]',0);
        if($specTag) {
            $spec = $specTag->text();
        }

        $price = 0;
        $priceContainerTag = $html->find('div[class="product-price-container"]',0);
        if($priceContainerTag) {
            $priceTag = $priceContainerTag->find('div[class="salePrice"]',0);
            if(!$priceTag) {
                $priceTag = $priceContainerTag->find('div[class="Price"]',0);
            }
            if($priceTag) {
                $price = $priceTag->text();
               // Logger::curllog("price here we go=".$price);
                $price = str_replace("Now","",$price);
               // Logger::curllog("price here we go2=".$price);
                $price = trim($price);
                $price = trim($price,"$");
            }            
        }


        Logger::curllog("price=".$price); 

        $description = "";
        $descriptionTag = $html->find('p[itemprop="description"]',0);
        if($descriptionTag) {
            $description = $descriptionTag->text();
        }
        Logger::curllog("description=".$description);  

        $image = "";
        $imageTag = $html->find('div[class="gallery-images"]',0);
        if($imageTag) {
            $imageTag = $imageTag->find('img',0);
            if($imageTag) {
                $image = $imageTag->src; 
            }

        }         

        $brand = "MichaelKors";

        $ret = [
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "image" => $image,
            "brand" => $brand,
            "source" => $source,
            "spec" => $spec,
            "category_id" => "4"
        ];  
        Logger::curllog("ret=".json_encode($ret));
        return $ret;      
    }

    public function getProductFromBodyShop($source) {
        $url = "curl $source -H 'Accept-Encoding: gzip, deflate, sdch, br' -H 'Accept-Language: en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Referer: https://www.thebodyshop.com/en-ca/body/body-cleansers-bath/c/c05386' -H 'Cookie: JSESSIONID=46EE2B318610106BAB2A8E488C4E02F1.app1; JSESSIONID=46EE2B318610106BAB2A8E488C4E02F1.app1; JSESSIONID=46EE2B318610106BAB2A8E488C4E02F1.app1; affiliateSource=Google; gtm_source=Google; gtm_medium=sem_brd; awin_conversion=false Sat, 10 Jun 2017 03:25:34 GMT; mt.utm_params=utm_source%3DGoogle%26utm_medium%3Dsem_brd%26utm_term%3Dbodyshop%26utm_content%3Dnull; k2c_Bodyshop_cids=Bodyshop_AJAO4tQt7VmSGWp; thebodyshop-ca-wishlist=\"\"; s.eVar15=684724097; tduid=undefined; mt.v=2.164356280.1494473135191; _ga=GA1.2.1351056554.1494473135; _gid=GA1.2.196778736.1494473154; _uetsid=_uetac1d4d61; k2c_history=; k2c_chat_a1=3%7C0%7C0; usi_items_in_cart=0; AWSELB=D1412F830465C273C2C58FBA2254AEE47B458A58A12DE7F479BC69884B6CB93B1E474FDE3CD11D886917A687A412C32020070AC59C93A5348E58A05AE7EB20DC8B12407E12E77E9599A4DB2D4DFF3F737E7DCE83DD; usi_subtotal=0; usi_product1=; usi_product2=; usi_product3=; __atuvc=1%7C19; __atuvs=5913d9c465f156e1000; sc_cookie_machine_id=1494473177502270925; sc_cookie_machine_guid=0d7889e0-556f-46cf-b198-c8f3a634fba5; sc_cookie_session_id_081BB555-61B0-4419-93D4-0048A489CB06=J2JUQRYZ-CF5C-F39A-8679-15CF1F70760B; u-upsellitc3198=seenChat; u-upsellit16072=seenChat' -H 'Connection: keep-alive' -H 'Cache-Control: max-age=0' --compressed";

        //Logger::curllog("url=".$url);
        $response = CurlUtil::raw($url);
        //$response = str_replace("");
        Logger::curllog("response=".$response);

        $html = str_get_html($response);

        $name = "";
        $nameTag = $html->find('h1[itemprop="name"]',0);
        if($nameTag) {
            $name = $nameTag->text();
        }
        Logger::curllog("name=".$name);

        $spec = "spec";  

        $price = 0;
        $priceTag = $html->find('span[itemprop="price"]',0);
        if($priceTag) {
            $price = $priceTag->text();
            $price = trim($price);
            $price = trim($price,"$");
        }
        Logger::curllog("price=".$price); 

        $description = "";
        $descriptionTag = $html->find('div[class="description-container"]',0);
        if($descriptionTag) {
            $descriptionTag = $descriptionTag->find('p[itemprop="description"]',0);
            if($descriptionTag) {
                $description = $descriptionTag->text();
            }
        }
        Logger::curllog("description=".$description);  

        $image = "";
        $imageTag = $html->find('div[class="product-media"]',0);
        if($imageTag) {
            $imageTag = $imageTag->find('source',0);
            if($imageTag) {
                $image = $imageTag->srcset; 
            }

        }         

        $brand = "BodyShop";

        $ret = [
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "image" => $image,
            "brand" => $brand,
            "source" => $source,
            "spec" => $spec,
            "category_id" => "4"
        ];  
        Logger::curllog("ret=".json_encode($ret));
        return $ret;      
    }


    public function getProductFromAldo($source) {
        $url = "curl $source -H 'Accept-Encoding: gzip, deflate, sdch, br' -H 'Accept-Language: en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Cache-Control: max-age=0' -H 'Cookie: ADRUM_BT=R:0|g:505c7196-937e-4853-a2bb-6999519c66b017679|i:1648786|e:935|n:aldo_689ee717-e80b-4b94-9833-5714a40e5d2e; optimizelyEndUserId=oeu1494470444739r0.6971643118139337; sessionId=44066754-8c65-43b7-996a-87e00c81569b; BVImplMain%20Site=2022; _gat_UA-49129446-1=1; __CT_Data=gpv=1&apv_39029_www02=1&cpv_39029_www02=1; x-aldo-api-version=2; ROUTEID=.node36; WRIgnore=true; _ga=GA1.2.734782571.1494470449; _gid=GA1.2.409185448.1494470450; _dc_gtm_UA-49129446-1=1; _uetsid=_uet5e0e2ff6; __qca=P0-947519578-1494470450741; liveagent_oref=; liveagent_sid=c12c8673-6802-4750-a407-9d56d14b8a63; liveagent_vc=2; liveagent_ptid=c12c8673-6802-4750-a407-9d56d14b8a63; rCookie=wmvlc5np9e4sg517fav23; ADRUM=s=1494470462314&r=https%3A%2F%2Fwww.aldoshoes.com%2Fca%2Fen%2Fwomen%2Fhandbags%2Ftotes%2FHutcheon-Blue%2Fp%2F49247485-4%3F0' -H 'Connection: keep-alive' --compressed";

        //Logger::curllog("url=".$url);
        $response = CurlUtil::raw($url);
        //$response = str_replace("");
        Logger::curllog("response=".$response);

        $response = str_replace("data-srcset","data_srcset",$response);
        
        $html = str_get_html($response);

        $name = "";
        $nameTag = $html->find('h1[class="c-buy-module__product-title"]',0);
        if($nameTag) {
            $name = $nameTag->text();
        }
        Logger::curllog("name=".$name);

        $spec = "";
        $specTag = $html->find('ul[class="c-product-description__section-list"]',0);
        if($specTag) {
            $specTag = $specTag->find('li');
            if($specTag) {
                foreach($specTag as $liDom) {
                    $spec = $liDom->text();

                }
                
            }
            
        }
        $spec = htmlspecialchars_decode($spec);
        Logger::curllog("spec=".$spec);      

        $price = 0;
        $priceTag = $html->find('span[class="c-product-price__formatted-price"]',0);
        if($priceTag) {
            $price = $priceTag->text();
            $price = trim($price);
            $price = trim($price,"$");
        }
        Logger::curllog("price=".$price); 

        $description = "";
        $descriptionTag = $html->find('div[class="c-product-description__section-content"]',0);
        if($descriptionTag) {
            $description = $descriptionTag->text();
        }
        Logger::curllog("description=".$description);  

        $image = "";
        $imageTag = $html->find('meta[property="og:image"]',0);
        if($imageTag) {

            $image = $imageTag->content;            


        }         

        $brand = "Aldo";

        $ret = [
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "image" => $image,
            "brand" => $brand,
            "source" => $source,
            "spec" => $spec,
            "category_id" => "4"
        ];  
        Logger::curllog("ret=".json_encode($ret));
        return $ret;      
    }


    public function getProductFromCoach($source) {
        $url = "curl $source -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Connection: keep-alive' -H 'Accept-Encoding: gzip, deflate, sdch' -H 'Accept-Language: en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36' --compressed";

        //Logger::curllog("url=".$url);
        $response = CurlUtil::raw($url);
        //$response = str_replace("");
        Logger::curllog("response=".$response);

        $html = str_get_html($response);

        $name = "";
        $nameTag = $html->find('meta[itemprop="name"]',0);
        if($nameTag) {
            $name = $nameTag->content;
        }
        Logger::curllog("name=".$name);

        $spec = "";
        $specTag = $html->find('dd[class="productDetails_SF"]',0);
        if($specTag) {
            $specTag = $specTag->find('li');
            if($specTag) {
                foreach($specTag as $liDom) {
                    $spec = $liDom->text();
                }
                
            }
            
        }
        Logger::curllog("spec=".$spec);      

        $price = 0;
        $priceTag = $html->find('span[itemprop="price"]',0);
        if($priceTag) {
            $price = $priceTag->text();
            $price = trim($price);
            $price = trim($price,"$");
        }
        Logger::curllog("price=".$price); 

        $description = "";
        $descriptionTag = $html->find('p[itemprop="description"]',0);
        if($descriptionTag) {
            $description = $descriptionTag->text();
        }
        Logger::curllog("description=".$description);  

        $image = "";
        $imageTag = $html->find('meta[property="og:image"]',0);
        if($imageTag) {
            $image = $imageTag->content;
        }         

        $brand = "Coach";

        $ret = [
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "image" => $image,
            "brand" => $brand,
            "source" => $source,
            "spec" => $spec,
            "category_id" => "4"
        ];  
        Logger::curllog("ret=".json_encode($ret));
        return $ret;      
    }

    public function getProductFromWalmart($source) {
        $url = "curl $source -H 'accept-encoding: gzip, deflate, sdch, br' -H 'accept-language: en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4' -H 'upgrade-insecure-requests: 1' -H 'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36' -H 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'cache-control: max-age=0' -H 'authority: www.walmart.ca' -H 'cookie: JSESSIONID=25A9D530973D161897157DEF2519D82E.restapp-108800098-16-114655279; cookieLanguageType=en; deliveryCatchment=1126; marketCatchment=2002; zone=1; originalHttpReferer=; walmart.shippingPostalCode=M6G2W5; walmart.csrf=26e7c11f247270f347e0dbdc00b80b0d0508298a-1494414634828-58ee9871103be0880d39bd95; wmt.c=0; userSegment=50-percent; akaau_P1=1494416434~id=a935530cf468e6b1d723d9b1652c38f8; TBV=7; headerType=whiteGM; _ga=GA1.2.1968641351.1494414904; _gid=GA1.2.2046984240.1494414904; AMCV_C4C6370453309C960A490D44%40AdobeOrg=793872103%7CMCIDTS%7C17297%7CMCMID%7C36175066977475163589214688126478062099%7CMCAID%7CNONE%7CMCAAMLH-1495019704%7C7%7CMCAAMB-1495019704%7CNRX38WO0n5BH8Th-nqAG_A; walmart.id=bf061ada-f187-4fe9-bd01-17545c2d1ccc; usrState=1; previousBreakpoint=desktop; wmt.breakpoint=d; mbox=check#true#1494414964|session#1494414903017-165568#1494416764|PC#1494414903017-165568.17_47#1495624506; walmart.locale=en; areaCode=M6G2W5; pageLoadVisualComplete=4637:1; __gads=ID=de53badaaa475038:T=1494414639:S=ALNI_MZyGpw8vMdllK4WVeEx0YZzbOGWPA; BVImplmain_site=2036; walmart.nearestPostalCode=M6G2W5; s_cc=true; BVBRANDID=cc7d5357-8719-4039-8ffb-f3e3d5d6dce7; BVBRANDSID=0104f7eb-64e3-4617-a446-10a7210d246f; gpv_pagename=Product%3A%20Baby%20Ddrops%C2%AE%20Liquid%20Vitamin%20D3%20Vitamin%20Supplement%2C%20400%20IU; s_ppvl=%5B%5BB%5D%5D; og_session_id=af0a84f8847311e3b233bc764e1107f2.235387.1494414912; og_session_id_conf=af0a84f8847311e3b233bc764e1107f2.235387.1494414912; og_autoship=0; ENV=ak-dal-prod; s_evar16=Desktop; s_nr=1494415172126-New; fsr.s=%7B%22v2%22%3A-2%2C%22v1%22%3A1%2C%22cp%22%3A%7B%22cxreplayaws%22%3A%22true%22%7D%2C%22rid%22%3A%22de35433-94916641-f1b7-0039-b0435%22%2C%22ru%22%3A%22https%3A%2F%2Fwww.walmart.ca%2Fen%2Fip%2Fbaby-ddrops-liquid-vitamin-d3-vitamin-supplement-400-iu%2F6000189783716%3Frrid%3Drichrelevance%22%2C%22r%22%3A%22www.walmart.ca%22%2C%22st%22%3A%22%22%2C%22c%22%3A%22https%3A%2F%2Fwww.walmart.ca%2Fen%2Fip%2Fbaby-ddrops-liquid-vitamin-d3-vitamin-supplement-400-iu%2F6000189783716%22%2C%22pv%22%3A1%2C%22lc%22%3A%7B%22d3%22%3A%7B%22v%22%3A1%2C%22s%22%3Afalse%7D%7D%2C%22cd%22%3A3%2C%22sd%22%3A3%2C%22to%22%3A10%7D; s_ppv=Product%253A%2520Baby%2520Ddrops%25AE%2520Liquid%2520Vitamin%2520D3%2520Vitamin%2520Supplement%252C%2520400%2520IU%2C6%2C14%2C660%2C1270%2C277%2C1280%2C800%2C2%2CL' -H 'referer: https://www.walmart.ca/en/ip/baby-ddrops-liquid-vitamin-d3-vitamin-supplement-400-iu/6000189783716?rrid=richrelevance' --compressed";

        //Logger::curllog("url=".$url);
        $response = CurlUtil::raw($url);
        //$response = str_replace("");
        Logger::curllog("response=".$response);

        $html = str_get_html($response);

        $name = "";
        $nameTag = $html->find('h1[itemprop="name"]',0);
        if($nameTag) {
            $name = $nameTag->text();
        }
        Logger::curllog("name=".$name);

        $spec = "";
        $specTag = $html->find('p[class="description"]',0);
        if($specTag) {
            $spec = $specTag->text();
        }
        Logger::curllog("spec=".$spec);      

        $price = 0;
        $priceTag = $html->find('span[itemprop="price"]',0);
        if($priceTag) {
            $price = $priceTag->text();

            $price = trim($price,"$");
        }
        Logger::curllog("price=".$price); 

        $description = "";
        $descriptionTag = $html->find('div[itemprop="description"]',0);
        if($descriptionTag) {
            $description = $descriptionTag->text();
        }
        Logger::curllog("description=".$description);  

        $image = "";
        $imageTag = $html->find('img[itemprop="image"]',0);
        if($imageTag) {
            $image = $imageTag->src;
            $pos = stripos($image,"//");
            if($pos === 0) {
                $image = "http:".$image;
            }
        }         

        $brand = "";
        $brandTag = $html->find('span[itemprop="brand"]',0);
        if($brandTag) {
            $brand = $brandTag->text();
            $brand = trim($brand);
        }

        $ret = [
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "image" => $image,
            "brand" => $brand,
            "source" => $source,
            "spec" => $spec,
            "crop_type" => "middle"
        ];  
        Logger::curllog("ret=".json_encode($ret));
        return $ret;      
    }
    public function getProductFromCostco($source) {
        
        //Logger::curllog("source=".$source);
        $url = "curl ".$source." -H 'Accept-Encoding: gzip, deflate, sdch, br' -H 'Accept-Language: en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Cache-Control: max-age=0' -H 'Cookie: AMCVS_97B21CFE5329614E0A490D45%40AdobeOrg=1; AMCV_97B21CFE5329614E0A490D45%40AdobeOrg=-1330315163%7CMCIDTS%7C17293%7CMCMID%7C33418360481032625714012746240126029856%7CMCAAMLH-1494713041%7C7%7CMCAAMB-1494713041%7CcIBAx_aQzFEHcPoEv0GwcQ%7CMCOPTOUT-1494115441s%7CNONE%7CMCAID%7CNONE; mbox=session#0ced82daa4634e79a0cd3a7698659292#1494110103|PC#0ced82daa4634e79a0cd3a7698659292.17_59#1557353043; ak_bmsc=7EAC08C94E3EE4BC3070AA071E12AD55D194C042304F000053470E59177BAA23~plpDcXX3lUhh1mHp02TvurF/i9sFdG4UIIipBXGxz3qDR9GGFSwyjx/44jk+q0E0L/LRjeP6uUFA2gDRVUeaFXxsAQFQAsML4790XdWFDL2hSliPPi3FKMx10F9nAA66mhk37HreHawOoH6z1c43AfOcAxJmf1yeFbVBrmvOCJpCZYtnJftI8HMIGdUlCWh3lotb39lzUUotMWNcqAaCzzZg==; s_cc=true; __CT_Data=gpv=1&apv_81_www33=1&cpv_81_www33=1; WRIgnore=true; WRUID20170327=0; spid=9B2D7865-4020-4FFA-80B4-CF32322F6F17; sp_ssid=1494108249163; BVImplmain_site=20040; BVBRANDID=8f7cf078-e8aa-42de-9358-4d252d110226; BVBRANDSID=fe1eea93-4aeb-48ea-8f0b-2306bedd6738; s_sq=cwcostcocaprod%3D%2526c.%2526a.%2526activitymap.%2526page%253Dhttps%25253A%25252F%25252Fwww.costco.ca%25252FKirkland-Signature-Krill-Oil-500mg----120-Softgels-.product.100284782.html%2526link%253DSet%252520Language%252520and%252520Region%2526region%253DcostcoModalText%2526.activitymap%2526.a%2526.c; C_LOC=CAAB' -H 'Connection: keep-alive' --compressed";
        //Logger::curllog("url=".$url);
        $response = CurlUtil::raw($url);

        $html = str_get_html($response);

        $name = "";
        $nameTag = $html->find('h1[itemprop="name"]',0);
        if($nameTag) {
            $name = $nameTag->text();
        }
        $price = 0;
        $yourPriceTag = $html->find('span[class="op-value"]',0);

        if($yourPriceTag) {

            $pricebase64 = $yourPriceTag->text();
            $price = base64_decode($pricebase64);
        }

        $description = "";
        $descriptionTag = $html->find('meta[name="description"]',0);
        if($descriptionTag) {
            $description = $descriptionTag->content;
        }

        $image = "";
        $imageTag = $html->find('img[id="initialProductImage"]',0);
        if($imageTag) {
            $image = $imageTag->src;
        }

        $brand = "";
        $brandTag = $html->find('div[class="product-info-specs"]',0);
        if($brandTag) {
            //echo "oooo";
            $brand = $brandTag->text();
            $brand = str_replace("Brand:","",$brand);
            $brand = trim($brand);
        }

        $spec = "spec";
        return [
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "image" => $image,
            "brand" => $brand,
            "source" => $source,
            "spec" => $spec
        ];
    }
/*
_csrf:WmgwSmRobnISHUANCjgqBzk/ZgAoKgEcN15HGwYSFCscCWM9ETxaBw==
Product[name]:faefaw
Product[name_zh]:faewfaw
Product[description]:feaw
Product[description_zh]:fawefa
Product[price]:12
Product[brand_id]:1
Product[origin_id]:1
Product[spec]:faefa
Product[spec_zh]:feawwa
Product[category_id]:1
Product[source]:feafwa
*/

/*
saveload me{"_csrf":"LUtrOFB5WXdlPht\/PikdAk4cPXIcOzYZQH0caTIDIy5rKjhPJS1tAg==","Product":{"name":"faerfa","name_zh":"faefewa","description":"c","description_zh":"fger","price":"12","brand_id":"1","origin_id":"1","spec":"gfefea","spec_zh":"fwefwa","category_id":"1","source":"faewfwaf"}}|||"Product"scope is not null{"name":"faerfa","name_zh":"faefewa","description":"c","description_zh":"fger","price":"12","brand_id":"1","origin_id":"1","spec":"gfefea","spec_zh":"fwefwa","category_id":"1","source":"faewfwaf"}yes load success
*/
    public function handle($productInfo) {
        $postData = [];
        $postData["_csrf"] = "WmgwSmRobnISHUANCjgqBzk/ZgAoKgEcN15HGwYSFCscCWM9ETxaBw==";
        /*
        $postData["Product[name]"] = $productInfo["name"];
        $postData["Product[name_zh]"] = $productInfo["name"];

        $postData["Product[description]"] = $productInfo["description"];
        $postData["Product[description_zh]"] = $productInfo["description"];   
        
        $postData["Product[price]"] = $productInfo["price"];
        $postData["Product[brand_id]"] = 1;  
        $postData["Product[origin_id]"] = 1;    

        $postData["Product[spec]"] = "spec";
        $postData["Product[spec_zh]"] = "spec";   

        $postData["Product[category_id]"] = 1;   
        $postData["Product[source]"] = $productInfo["source"];  
        */ 

        $model = new Product();
        $product = [];
        echo $productInfo["source"];

        $brand = $productInfo["brand"];
        $brandObj = Brand::find()->where(["name" => $brand])->one();
        $brand_id = 0;
        if(!$brandObj && $brand) {
            $brandObj = new Brand();
            $brandObj["name"] = $brand;
            $brandObj->save();

        }
        $brand_id = $brandObj&&$brandObj["id"]?$brandObj["id"]:0;

        $name = trim($productInfo["name"]);
        $name_zh = TranslateUtil::toChinese($name);
        $product["name"] = $name;
        $product["name_zh"] = $name_zh;
        $description = trim($productInfo["description"]);
        $description_zh = TranslateUtil::toChinese($description);
        $product["description"] = $description;
        $product["description_zh"] = $description_zh;
        $product["price"] = $productInfo["price"] + 15;
        $product["origin_price"] = $productInfo["price"];
        $product["brand_id"] = $brand_id;
        $product["origin_id"] = "2";
        $spec = trim($productInfo["spec"]);
        $spec_zh = TranslateUtil::toChinese($spec);
        $product["spec"] = $spec;
        $product["spec_zh"] = $spec_zh;
        $product["category_id"] = isset($productInfo["category_id"])?$productInfo["category_id"]:"1";
        $product["source"] = $productInfo["source"];
        $postData["Product"] = $product;
        $productManager = new ProductManager($model);
        $productId = $productManager->saveProduct($postData);  
        echo "productId=$productId";
        if($productId) {
            $productImageManager = new ProductImageManager($productId);

            $image = $productInfo["image"];
            $pos = stripos($image,"//");
            if($pos === 0) {
                $image = "http:".$image;
            }            
            $crop_type = isset($productInfo["crop_type"])?$productInfo["crop_type"]:"bottom";
            $productImageManager->saveImage($image,$crop_type);              
        }
    }

/*
{"name_zh":"Kirkland Signature Krill Oil 500mg -- 120 Softgels ","description_zh":"Kirkland Signature Krill Oil 500mg -- 120 Softgels ","spec_zh":"Kirkland Signature Krill Oil 500mg -- 120 Softgels ","category_id":1}
{"name_zh":"Kirkland Signature Krill Oil 500mg -- 120 Softgels ","description_zh":"Kirkland Signature Krill Oil 500mg -- 120 Softgels ","spec_zh":"Kirkland Signature Krill Oil 500mg -- 120 Softgels ","category_id":1}

{"name":"fewa","name_zh":"fweafwa","description":"fawef","description_zh":"fawefwa","price":"12","brand_id":"1","origin_id":"1","spec":"faewwa","spec_zh":"fwaefwa","category_id":"1","source":"feawfwa"}
{"name":"fewa","name_zh":"fweafwa","description":"fawef","description_zh":"fawefwa","price":"12","brand_id":"1","origin_id":"1","spec":"faewwa","spec_zh":"fwaefwa","category_id":"1","source":"feawfwa"}yes load success
*/



    public function actionGenerate() {
        $records = Source::find()->all();
        foreach($records as $record) {

            $source = $record["url"];
            echo "source===$source";
            $source = str_replace("'", "\\'", $source);
            $source = str_replace("(", "\\(", $source);
            $source = str_replace(")", "\\)", $source);
            $productWithSource = Product::find()->where(["source" => $source])->one();
            if($productWithSource) {
                continue;
            }
            echo "source===$source";
            $productInfo = null;
            $pos = stripos($source,"www.costco.ca");
            if($pos !== false) {
                $productInfo = self::getProductFromCostco($source);
            }
            $pos = stripos($source,"www.walmart.ca");
            if($pos !== false) {
                $productInfo = self::getProductFromWalmart($source);
            }   
            $pos = stripos($source,"www.coach.com");
            if($pos !== false) {
                $productInfo = self::getProductFromCoach($source);
            }  
            $pos = stripos($source,"www.aldoshoes.com");
            if($pos !== false) {
                $productInfo = self::getProductFromAldo($source);
            }   
            $pos = stripos($source,"www.thebodyshop.com");
            if($pos !== false) {
                $productInfo = self::getProductFromBodyShop($source);
            }      
            $pos = stripos($source,"www.michaelkors.ca");
            if($pos !== false) {
                $productInfo = self::getProductFromMichaelKors($source);
            }                        
            
            if($productInfo)  {
                self::handle($productInfo);
            } 
            
        }

        $settingManager = new SettingManager;
        $settingManager->generateJson();        
    }

    /**
     * Lists all Source models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SourceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Source model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Source model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Source();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            self::actionGenerate();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Source model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Source model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Source model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Source the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Source::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
