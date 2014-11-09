<?php
define('DEBUG', $_GET["debug"]);
require_once('simplePie/autoloader.php');
require 'db.class.php';
$obj = new PostAPI();

//Array of feed links to parse 
$arr = array(
    'http://news.google.gr/news?pz=1&cf=all&ned=el_gr&hl=el&topic=n&output=rss'
    /*'http://www.real.gr/Rss.aspx?pid=149',
    'http://www.real.gr/Rss.aspx?pid=474',
    'http://www.madata.gr/feed/epikairotita/social/index.1.rss',
    'http://www.protothema.gr/rss/news/general/',
    'http://feeds.feedburner.com/skai/PLwa',
    'http://news.google.gr/news?pz=1&cf=all&ned=el_gr&hl=el&topic=n&output=rss',
    'http://news.in.gr/feed/news/greece/',
    'http://sports.in.gr/feed/sports/',
    'http://www.seleo.gr/?format=feed',
    'http://www.proininews.gr/feed/',
    'http://www.kavalapress.gr/feed/',
    'http://www.larisanews.gr/feed',
    'http://www.larisanew.gr/website/feed/',
    'http://www.neakriti.gr/Rss.aspx?pid=931',
    'http://www.neakriti.gr/Rss.aspx?pid=826',
    'http://www.tanea.gr/rss.axd?pgid=13',
    'http://www.doriforikanea.gr/newsite/xml_all.php',
    'http://www.newsbeast.gr/feeds/greece',
    'http://www.newsbeast.gr/feeds/culture',
    'http://www.nooz.gr/rss.xml?format=xml',
    'http://feeds.feedburner.com/mylefkada',
    'feed://www.trikaladay.gr/rss.aspx?UICulture=el-GR&category=8',
    'feed://www.trikaladay.gr/rss.aspx?UICulture=el-GR&category=13',
    'feed://www.evia-news.gr/feed',
    'http://www.tempo.gr/mixed/rss/66-tempogr-teleutaia-nea'*/
);

foreach ($arr as &$value) {
    getFeed($value);
}

function getFeed($url)
{
    global $obj;
    
    //Feed object
    $feed = new SimplePie();
    //Set feed url to parse
    $feed->set_feed_url($url);
    $feed->init();
    
    // $feed->set_timeout(5);
    
    //Set our custom user agent
    $feed->set_useragent('Mozilla/4.0 ');
    $feed->handle_content_type();
    $feed->set_stupidly_fast(false);
    if ($feed->error) {
        print_r($feed->error);
    }
    
    // echo count($feed->get_items());
    
    //SimplePie can't parse channel name and feed image, so we are getting them by ourselves
    $doc = new DOMDocument;
    $doc->load($url);
    $title  = $doc->getElementsByTagName('channel');
    $xpath  = new DOMXpath($doc);
    $source = $xpath->evaluate('string(/rss/channel/title)');
    //If source in feed is missing(not so rare), get host component from url and use it as source
    if (empty($source)) {
        $source = parse_url($url, PHP_URL_HOST);
    }
    //Get feed image
    $feed_img = $xpath->evaluate('string(/rss/channel/image/url)');
    
    foreach ($feed->get_items() as $item):
    //Merge title and content string
        $data = $item->get_title() . " " . $item->get_content();
        if (preg_match("/(Αγιά|Αγία Βαρβάρα|Αγία Μαρίνα Κορωπίου|Αγία Μαρίνα Λέρου|Αγία Παρασκευή|Αγία Τριάδα|Αγιάσος|Άγιοι Ανάργυροι Αττικής|Άγιοι Απόστολοι|Άγιοι Θεόδωροι|Άγιος Αθανάσιος|Άγιος Βασίλειος|Άγιος Γεώργιος|Άγιος Δημήτριος|Άγιος Ιωάννης Ρέντης|Άγιος Κωνσταντίνος|Άγιος Νικόλαος|Άγιος Στέφανος|Αγριά|Αγρίνιο|Άδενδρο|Αθήνα|Αθίκια|Αιανή|Αιάντειο|Αιγάλεω|Αίγινα|Αιγίνιο|Αίγιο|Αιτωλικό|Αλεξάνδρεια|Αλεξανδρούπολη|Αλίαρτος|Αλιβέρι|Άλιμος|Αλιστράτη|Αλμυρός|Αμαλιάδα|Αμάρυνθος|Αμπελάκια|Αμπελόκηποι|Αμπελώνας|Αμύνταιο|Αμφίκλεια|Αμφιλοχία|Αμφίπολη|Άμφισσα|Ανάβυσσος|Ανατολή|Ανατολικό|Ανδραβίδα|Ανθούσα|Άνοιξη|Αντίκυρα|Αντιμάχεια|Άνω Λιόσια|Ανώγεια|Αξιούπολη|Αράχωβα|Άργος|Άργος Ορεστικό|Αργοστόλι|Αργυρούπολη|Αριδαία|Αρκαλοχώρι|Αρναία|Άρτα|Αρτέμιδα|Αρχάγγελος|Ασβεστοχώρι|Ασπροβάλτα|Ασπρόπυργος|Άσσηρος|Άσσος|Αστακός|Άστρος|Αταλάντη|Αυλώνα|Αφάντου|Αχαρνές|Βάγια|Βαθύ|Βαθύλακκος|Βάρδα|Βάρη|Βαρθολομιό|Βασιλικά|Βελβεντός|Βελεστίνο|Βέλο|Βέροια|Βλαχιώτης|Βόλος|Βόνιτσα|Βούλα|Βουλιαγμένη|Βραχάτι|Βραχναίικα|Βριλήσσια|Βροντάδος|Βροντού|Βύρωνας|Βύτινα|Γαλατάδες|Γαλατάς|Γαλατινή|Γαλάτιστα|Γαλάτσι|Γαργαλιάνοι|Γαστούνη|Γέρακας|Γέφυρα|Γιαννιτσά|Γιάννουλη|Γλυκά Νερά|Γλυφάδα|Γόννοι|Γουμένισσα|Γρεβενά|Γύθειο|Γυμνό|Δαράτσος|Δάφνη|Δελφοί|Δεμένικα|Δεσκάτη|Δεσφίνα|Δήλεσι|Διακοπτό|Διδυμότειχο|Διμήνιο|Διόνυσος|Δίστομο|Δοξάτο|Δράμα|Δραπετσώνα|Δροσιά|Δρυμός|Έδεσσα|Εκάλη|Ελασσόνα|Ελάτεια|Ελεούσα|Κορδελιό|Ελευθερούπολη|Ελευσίνα|Ελληνικό|Επανομή|Επάνω Αρχάνες|Ερέτρια|Ερμιόνη|Ερμούπολη|Ερυθρές|Ευξεινούπολη|Εύοσμο|Ευρωπό|Εχίνος|Ζαγκλιβέρι|Ζαγορά|Ζάκυνθος|Ζαρός|Ζαχάρω|Ζευγολατειό|Ζεφύρι|Ζηπάριο|Ζωγράφου|Ηγουμενίτσα|Ηλιούπολη|Ηράκλεια|Ηράκλειο|Ηράκλειο Αττικής|Θέρμη|Θεσσαλονίκη|Θήβα|Θήρα|Θρακομακεδόνες|Ιαλυσός|Ίασμος|Ιεράπετρα|Ιερισσός|Ίλιον|Ιστιαία|Ιτέα|Ιωάννινα|Καβάλα|Καινούργιο|Καισαριανή|Καλαμαριά|Καλαμάτα|Καλαμπάκα|Καλαμπάκι|Καλλιθέα|Καλοχώρι|Καλύβια Θορικού|Καλυθιές|Καματερό|Καμένα Βούρλα|Κανάλι|Καναλλάκι|Καπανδρίτι|Καρδίτσα|Καρδιτσομαγούλα|Καρίτσα|Καρλόβασι|Κάρπαθος |Καρπενήσι|Κάρυστος|Κασσάνδρεια|Καστοριά|Κατερίνη|Κατούνα|Κατοχή|Κατσικάς|Κάτω Αχαΐα|Κάτω Νευροκόπι|Κάτω Τιθορέα|Κένταυρος|Κερατέα|Κερατσίνι|Κέρκυρα|Κέφαλος|Κηφισιά|Κιάτο|Κιλκίς|Κιμμέρια|Κίσσαμος|Κίτσι|Κοζάνη|Κολινδρός|Κομοτηνή|Κομπότι|Κόνιτσα|Κοπανός|Κόρινθος|Κορινός|Κορυδαλλός|Κορωπί|Κοσκινού|Κουνουπιδιανά|Κουφάλια|Κρανέα Ελασσόνας|Κρανίδι|Κρεμαστή|Κρέστενα|Κρηνίδες|Κρόκος|Κρουσώνας|Κρύα Βρύση|Κρυονέρι|Κύμη|Κύμινα|Κυπαρισσία|Κυριάκι|Κως|Λαγκαδάς|Λαγυνά|Λαμία|Λάρισα|Λαύριο|Λεπενού|Λεπτοκαρυά|Λευκάδα|Λευκίμμη|Λευκώνας|Λεχαινά|Λέχαιο|Λεωνίδιο|Ληξούρι|Λητή|Λιβαδειά|Λιβάδι|Λιβανάτες|Λιμενάρια|Λιμένας Θάσου|Λιμένας Μαρκοπούλου|Λιμένας Χερσονήσου|Λιοντάρι|Λιτόχωρο|Λούρος|Λουτρά Αιδηψού|Λουτράκι|Λυγουριό|Λυκόβρυση|Μαγούλα|Μακρακώμη|Μακροχώρι|Μαλεσίνα|Μάλια|Μάνδρα|Μανιάκοι|Μαραθώνας|Μαρκόπουλο Μεσογαίας|Μαρκόπουλο Ωρωπού|Μαρούσι|Μαρτίνο|Μεγάλα Καλύβια|Μεγάλη Παναγία|Μεγαλόπολη|Μέγαρα|Μελίκη|Μελίσσια|Μενεμένη|Μεσολόγγι|Μεσσήνη|Μεταμόρφωση Αττικής|Μέτσοβο|Μοίρες|Μολάοι|Μοσχάτο|Μουζάκι|Μουρνιές|Μύκονος|Μύρινα|Μυτιλήνη|Μυτιληνιοί|Μώλος|Νάξος|Νάουσα|Νάουσα|Ναύπακτος|Ναύπλιο|Νέα Αγχίαλος|Νέα Αλικαρνασσός|Νέα Αρτάκη|Νέα Βρασνά|Νέα Βύσσα|Νέα Ερυθραία|Νέα Ζίχνη|Νέα Ιωνία|Νέα Καλλικράτεια|Νέα Καρβάλη|Νέα Κίος|Νέα Μάκρη|Νέα Μάλγαρα|Νέα Μεσημβρία|Νέα Μηχανιώνα|Μουδανιά|Νέα Παλάτια|Νέα Πεντέλη|Νέα Πέραμος|Νέα Σμύρνη|Νέα Τρίγλια|Νέα Φιλαδέλφεια|Νέα Χαλκηδόνα|Νεάπολη|Νεάπολη|Νεάπολη|Νεάπολη Βοιών|Νεμέα|Νέο Πετρίτσι|Νέο Ρύσιο|Νέο Σούλι|Νέο Ψυχικό|Νέοι Επιβάτες|Νέος Μαρμαράς|Νέος Μυλότοπος|Νέος Σκοπός|Νεοχώρι|Νεοχώρι|Νεροκούρος|Νιγρίτα|Νίκαια|Νίκαια|Νικήσιανη|Νικήτη|Ξάνθη|Ξηροπόταμος|Ξυλόκαστρο|Οβρυά|Οινόφυτα|Οιχαλία|Ορεστιάδα|Ορμύλια|Ορχομενός|Παιανία|Παλαιά Φώκαια|Παλαιό Φάληρο|Παλαιό Ψυχικό|Παλαιοχώρα|Πάλαιρος|Παλαμά|Παλλήνη|Παναιτώλιο|Πανόραμα|Παπάγος|Παραδείσι|Παραλία|Παραμυθιά|Πάργα|Παροικιά|Πάτρα|Πειραιάς|Πέλλα|Πεντέλη|Περαία|Πέραμα|Πέραμα|Περιβόλια|Περίσταση|Περιστέρι|Πετρούπολη|Πεύκη|Πλαγιάρι|Πλάκα Δήλεσι Βοιωτίας|Πλαταμώνας|Πλατύ|Πλωμάρι|Κάλυμνος|Πολίχνη Θεσσαλονίκης|Πολίχνιτος|Πολύγυρος|Πολύκαστρο|Πόρος|Ποταμός|Πρέβεζα|Προσοτσάνη|Πτολεμαΐδα|Πυλαία|Πυλίο|Πύλος|Πύργος|Ραφήνα|Ρέθυμνο|Ρίο|Ροδίτσα|Ροδοδάφνη|Ροδολίβος|Ροδόπολη|Ρόδο|Σαλαμίνα|Σάμος|Σάπες|Σαρωνίδα|Σελήνια|Σέρβια|Σέρρες|Σήμαντρα|Σητεία|Σιάτιστα|Σιδηρόκαστρο|Σίνδος|Σκάλα|Σκιάθος|Σκόπελος|Σκούταρι|Σκύδρα|Σούδα|Σούρπη|Σουφλί|Σοφάδες|Σοχός|Σπάρτη|Σπάτα|Σπερχειάδα|Σπέτσες|Σταμάτα|Σταυρός|Σταυρός|Σταυρούπολη|Στυλίδα|Συκιά|Συκιές|Συκούριο|Σύμη|Σχηματάρι|Ταύρος|Τερπνή|Τήνος|Τραγανό|Τριανδρία|Τρίκαλα|Τρίλοφος|Τρίπολη|Τσαρίτσανη|Τυμπάκι|Τύρναβος|Τυρός|Τυχερό|Ύδρα|Υμηττός|Φάλαννα|Φαρκαδόνα|Φάρσαλα|Φέρες|Φιλιάτες|Φιλιατρά|Φιλιππιάδα|Φιλοθέη|Φίλυρο|Φλώρινα|Φυλή|Χαϊδάρι|Χαλάνδρι|Χαλάστρα|Χαλκηδών|Χαλκίδα|Χαλκούτσι|Χανιά|Χίο|Χολαργό|Χορτιάτη|Χρυσούπολη|Χώρα Μεσσηνίας|Χαλκιδική|Χωριστή|Ψαχνά|Ωραιόκαστρο)/i", $data, $match)) {
            if (DEBUG) {
                echo $source . " " . $item->get_title() . " <b>" . $match[0] . "</b> <i>" . $item->get_base() . $item->get_permalink() . $item->get_date('Y-m-d H:i:s') . "\n <br />";
            }
            
            $title    = $item->get_title();
            $content  = $item->get_content();
            $link     = $item->get_permalink();
            $date     = $item->get_date('Y-m-d H:i:s');
            $img_link = json_decode(shortURL($feed_img), true);
            //Add to DB. Base64 encode html content and title. When retrieve later, just decode
            if ($obj->addToDB($title, base64_encode($content), base64_encode($link), $date, $source, $match[0], $lat, $lng, $img_link["id"])) {
                if (DEBUG) {
                    echo "OK";
                }
            }
        }
    endforeach;
    $feed->__destruct(); // Do what PHP should be doing on it's own.
    unset($item, $feed, $title, $content, $link, $date, $match[0], $lat, $lng, $obj);
    if (DEBUG) {
        echo "Memory usage after: " . number_format(memory_get_usage() / 1024);
    }
}

//Use Google's url shortener API for feed's image link. Returns JSON. API Doc: https://developers.google.com/url-shortener/v1/getting_started
function shortURL($url)
{
    $data        = array(
        "longUrl" => $url
    );
    $data_string = json_encode($data);
    
    $ch = curl_init('https://www.googleapis.com/urlshortener/v1/url');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
        //TODO Add gzip compression and handle decompression 
        //TODO Accept-Encoding: gzip,User-Agent: my program (gzip)
    ));
    
    $result = curl_exec($ch);
    return $result;
}
?>