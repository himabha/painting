<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Pojo_Web_Fonts
 */
class Pojo_Web_Fonts {

	protected static $_font_faces = array();

	protected static function _build_font_faces() {
		if ( ! empty( self::$_font_faces ) )
			return;

		self::$_font_faces = apply_filters(
			'pojo_register_font_faces',
			array(
				// Normal fonts.
				'Arial' => 'normal',
				'Tahoma' => 'normal',
				'Verdana' => 'normal',
				'Helvetica' => 'normal',
				'Times New Roman' => 'normal',
				'Trebuchet MS' => 'normal',
				'Georgia' => 'normal',

				// Google Fonts (last update: 04/08/2016).
				'ABeeZee' => 'googlefonts',
				'Abel' => 'googlefonts',
				'Abril Fatface' => 'googlefonts',
				'Aclonica' => 'googlefonts',
				'Acme' => 'googlefonts',
				'Actor' => 'googlefonts',
				'Adamina' => 'googlefonts',
				'Advent Pro' => 'googlefonts',
				'Aguafina Script' => 'googlefonts',
				'Akronim' => 'googlefonts',
				'Aladin' => 'googlefonts',
				'Aldrich' => 'googlefonts',
				'Alef' => 'googlefonts',
				'Alef Hebrew' => 'earlyaccess', // Hack for Google Early Access.
				'Alegreya' => 'googlefonts',
				'Alegreya SC' => 'googlefonts',
				'Alegreya Sans' => 'googlefonts',
				'Alegreya Sans SC' => 'googlefonts',
				'Alex Brush' => 'googlefonts',
				'Alfa Slab One' => 'googlefonts',
				'Alice' => 'googlefonts',
				'Alike' => 'googlefonts',
				'Alike Angular' => 'googlefonts',
				'Allan' => 'googlefonts',
				'Allerta' => 'googlefonts',
				'Allerta Stencil' => 'googlefonts',
				'Allura' => 'googlefonts',
				'Almendra' => 'googlefonts',
				'Almendra Display' => 'googlefonts',
				'Almendra SC' => 'googlefonts',
				'Amarante' => 'googlefonts',
				'Amaranth' => 'googlefonts',
				'Amatic SC' => 'googlefonts',
				'Amethysta' => 'googlefonts',
				'Amatica SC' => 'googlefonts',
				'Amiko' => 'googlefonts',
				'Amiri' => 'googlefonts',
				'Amita' => 'googlefonts',
				'Anaheim' => 'googlefonts',
				'Andada' => 'googlefonts',
				'Andika' => 'googlefonts',
				'Angkor' => 'googlefonts',
				'Annie Use Your Telescope' => 'googlefonts',
				'Anonymous Pro' => 'googlefonts',
				'Antic' => 'googlefonts',
				'Antic Didone' => 'googlefonts',
				'Antic Slab' => 'googlefonts',
				'Anton' => 'googlefonts',
				'Arapey' => 'googlefonts',
				'Arbutus' => 'googlefonts',
				'Arbutus Slab' => 'googlefonts',
				'Architects Daughter' => 'googlefonts',
				'Archivo Black' => 'googlefonts',
				'Archivo Narrow' => 'googlefonts',
				'Aref Ruqaa' => 'googlefonts',
				'Arima Madurai' => 'googlefonts',
				'Arimo' => 'googlefonts',
				'Arizonia' => 'googlefonts',
				'Armata' => 'googlefonts',
				'Artifika' => 'googlefonts',
				'Arvo' => 'googlefonts',
				'Arya' => 'googlefonts',
				'Asap' => 'googlefonts',
				'Asar' => 'googlefonts',
				'Asset' => 'googlefonts',
				'Assistant' => 'googlefonts',
				'Astloch' => 'googlefonts',
				'Asul' => 'googlefonts',
				'Athiti' => 'googlefonts',
				'Atma' => 'googlefonts',
				'Atomic Age' => 'googlefonts',
				'Aubrey' => 'googlefonts',
				'Audiowide' => 'googlefonts',
				'Autour One' => 'googlefonts',
				'Average' => 'googlefonts',
				'Average Sans' => 'googlefonts',
				'Averia Gruesa Libre' => 'googlefonts',
				'Averia Libre' => 'googlefonts',
				'Averia Sans Libre' => 'googlefonts',
				'Averia Serif Libre' => 'googlefonts',
				'Bad Script' => 'googlefonts',
				'Baloo' => 'googlefonts',
				'Baloo Bhai' => 'googlefonts',
				'Baloo Da' => 'googlefonts',
				'Baloo Thambi' => 'googlefonts',
				'Balthazar' => 'googlefonts',
				'Bangers' => 'googlefonts',
				'Basic' => 'googlefonts',
				'Battambang' => 'googlefonts',
				'Baumans' => 'googlefonts',
				'Bayon' => 'googlefonts',
				'Belgrano' => 'googlefonts',
				'Belleza' => 'googlefonts',
				'BenchNine' => 'googlefonts',
				'Bentham' => 'googlefonts',
				'Berkshire Swash' => 'googlefonts',
				'Bevan' => 'googlefonts',
				'Bigelow Rules' => 'googlefonts',
				'Bigshot One' => 'googlefonts',
				'Bilbo' => 'googlefonts',
				'Bilbo Swash Caps' => 'googlefonts',
				'BioRhyme' => 'googlefonts',
				'BioRhyme Expanded' => 'googlefonts',
				'Biryani' => 'googlefonts',
				'Bitter' => 'googlefonts',
				'Black Ops One' => 'googlefonts',
				'Bokor' => 'googlefonts',
				'Bonbon' => 'googlefonts',
				'Boogaloo' => 'googlefonts',
				'Bowlby One' => 'googlefonts',
				'Bowlby One SC' => 'googlefonts',
				'Brawler' => 'googlefonts',
				'Bree Serif' => 'googlefonts',
				'Bubblegum Sans' => 'googlefonts',
				'Bubbler One' => 'googlefonts',
				'Buda' => 'googlefonts',
				'Buenard' => 'googlefonts',
				'Bungee' => 'googlefonts',
				'Bungee Hairline' => 'googlefonts',
				'Bungee Inline' => 'googlefonts',
				'Bungee Outline' => 'googlefonts',
				'Bungee Shade' => 'googlefonts',
				'Butcherman' => 'googlefonts',
				'Butterfly Kids' => 'googlefonts',
				'Cabin' => 'googlefonts',
				'Cabin Condensed' => 'googlefonts',
				'Cabin Sketch' => 'googlefonts',
				'Caesar Dressing' => 'googlefonts',
				'Cagliostro' => 'googlefonts',
				'Cairo' => 'googlefonts',
				'Calligraffitti' => 'googlefonts',
				'Cambay' => 'googlefonts',
				'Cambo' => 'googlefonts',
				'Candal' => 'googlefonts',
				'Cantarell' => 'googlefonts',
				'Cantata One' => 'googlefonts',
				'Cantora One' => 'googlefonts',
				'Capriola' => 'googlefonts',
				'Cardo' => 'googlefonts',
				'Carme' => 'googlefonts',
				'Carmela' => 'local',
				'Carrois Gothic' => 'googlefonts',
				'Carrois Gothic SC' => 'googlefonts',
				'Carter One' => 'googlefonts',
				'Carmelit' => 'local',
				'Catamaran' => 'local',
				'Caudex' => 'googlefonts',
				'Caveat' => 'googlefonts',
				'Caveat Brush' => 'googlefonts',
				'Cedarville Cursive' => 'googlefonts',
				'Ceviche One' => 'googlefonts',
				'Changa' => 'googlefonts',
				'Changa One' => 'googlefonts',
				'Chango' => 'googlefonts',
				'Chathura' => 'googlefonts',
				'Chau Philomene One' => 'googlefonts',
				'Chela One' => 'googlefonts',
				'Chelsea Market' => 'googlefonts',
				'Chenla' => 'googlefonts',
				'Cherry Cream Soda' => 'googlefonts',
				'Cherry Swash' => 'googlefonts',
				'Chewy' => 'googlefonts',
				'Chicle' => 'googlefonts',
				'Chivo' => 'googlefonts',
				'Chonburi' => 'googlefonts',
				'Cinzel' => 'googlefonts',
				'Cinzel Decorative' => 'googlefonts',
				'Clicker Script' => 'googlefonts',
				'Coda' => 'googlefonts',
				'Coda Caption' => 'googlefonts',
				'Codystar' => 'googlefonts',
				'Coiny' => 'googlefonts',
				'Combo' => 'googlefonts',
				'Comfortaa' => 'googlefonts',
				'Coming Soon' => 'googlefonts',
				'Concert One' => 'googlefonts',
				'Condiment' => 'googlefonts',
				'Content' => 'googlefonts',
				'Contrail One' => 'googlefonts',
				'Convergence' => 'googlefonts',
				'Cookie' => 'googlefonts',
				'Copse' => 'googlefonts',
				'Corben' => 'googlefonts',
				'Cormorant' => 'googlefonts',
				'Cormorant Garamond' => 'googlefonts',
				'Cormorant Infant' => 'googlefonts',
				'Cormorant SC' => 'googlefonts',
				'Cormorant Unicase' => 'googlefonts',
				'Cormorant Upright' => 'googlefonts',
				'Courgette' => 'googlefonts',
				'Cousine' => 'googlefonts',
				'Coustard' => 'googlefonts',
				'Covered By Your Grace' => 'googlefonts',
				'Crafty Girls' => 'googlefonts',
				'Creepster' => 'googlefonts',
				'Crete Round' => 'googlefonts',
				'Crimson Text' => 'googlefonts',
				'Croissant One' => 'googlefonts',
				'Crushed' => 'googlefonts',
				'Cuprum' => 'googlefonts',
				'Cutive' => 'googlefonts',
				'Cutive Mono' => 'googlefonts',
				'Damion' => 'googlefonts',
				'Dancing Script' => 'googlefonts',
				'Dangrek' => 'googlefonts',
				'Dawning of a New Day' => 'googlefonts',
				'Days One' => 'googlefonts',
				'David Libre' => 'googlefonts',
				'Delius' => 'googlefonts',
				'Delius Swash Caps' => 'googlefonts',
				'Delius Unicase' => 'googlefonts',
				'Della Respira' => 'googlefonts',
				'Denk One' => 'googlefonts',
				'Dekko' => 'googlefonts',
				'Devonshire' => 'googlefonts',
				'Dhurjati' => 'googlefonts',
				'Didact Gothic' => 'googlefonts',
				'Diplomata' => 'googlefonts',
				'Diplomata SC' => 'googlefonts',
				'Domine' => 'googlefonts',
				'Donegal One' => 'googlefonts',
				'Doppio One' => 'googlefonts',
				'Dorsa' => 'googlefonts',
				'Dosis' => 'googlefonts',
				'Dr Sugiyama' => 'googlefonts',
				'Droid Sans' => 'googlefonts',
				'Droid Sans Mono' => 'googlefonts',
				'Droid Serif' => 'googlefonts',
				'Droid Arabic Kufi' => 'earlyaccess',
				'Droid Arabic Naskh' => 'earlyaccess',
				'Duru Sans' => 'googlefonts',
				'Dynalight' => 'googlefonts',
				'EB Garamond' => 'googlefonts',
				'Eagle Lake' => 'googlefonts',
				'Eater' => 'googlefonts',
				'Economica' => 'googlefonts',
				'Eczar' => 'googlefonts',
				'Ek Mukta' => 'googlefonts',
				'El Messiri' => 'googlefonts',
				'Electrolize' => 'googlefonts',
				'Elsie' => 'googlefonts',
				'Elsie Swash Caps' => 'googlefonts',
				'Emblema One' => 'googlefonts',
				'Emilys Candy' => 'googlefonts',
				'Engagement' => 'googlefonts',
				'Englebert' => 'googlefonts',
				'Enriqueta' => 'googlefonts',
				'Erica One' => 'googlefonts',
				'Esteban' => 'googlefonts',
				'Euphoria Script' => 'googlefonts',
				'Ewert' => 'googlefonts',
				'Exo' => 'googlefonts',
				'Exo 2' => 'googlefonts',
				'Expletus Sans' => 'googlefonts',
				'Fanwood Text' => 'googlefonts',
				'Farsan' => 'googlefonts',
				'Fascinate' => 'googlefonts',
				'Fascinate Inline' => 'googlefonts',
				'Faster One' => 'googlefonts',
				'Fasthand' => 'googlefonts',
				'Fauna One' => 'googlefonts',
				'Federant' => 'googlefonts',
				'Federo' => 'googlefonts',
				'Felipa' => 'googlefonts',
				'Fenix' => 'googlefonts',
				'Finger Paint' => 'googlefonts',
				'Fira Mono' => 'googlefonts',
				'Fira Sans' => 'googlefonts',
				'Fjalla One' => 'googlefonts',
				'Fjord One' => 'googlefonts',
				'Flamenco' => 'googlefonts',
				'Flavors' => 'googlefonts',
				'Fondamento' => 'googlefonts',
				'Fontdiner Swanky' => 'googlefonts',
				'Forum' => 'googlefonts',
				'Francois One' => 'googlefonts',
				'Frank Ruhl Libre' => 'googlefonts',
				'Freckle Face' => 'googlefonts',
				'Fredericka the Great' => 'googlefonts',
				'Fredoka One' => 'googlefonts',
				'Freehand' => 'googlefonts',
				'Fresca' => 'googlefonts',
				'Frijole' => 'googlefonts',
				'Fruktur' => 'googlefonts',
				'Fugaz One' => 'googlefonts',
				'GFS Didot' => 'googlefonts',
				'GFS Neohellenic' => 'googlefonts',
				'Gabriela' => 'googlefonts',
				'Gafata' => 'googlefonts',
				'Galada' => 'googlefonts',
				'Galdeano' => 'googlefonts',
				'Galindo' => 'googlefonts',
				'Gentium Basic' => 'googlefonts',
				'Gentium Book Basic' => 'googlefonts',
				'Geo' => 'googlefonts',
				'Geostar' => 'googlefonts',
				'Geostar Fill' => 'googlefonts',
				'Germania One' => 'googlefonts',
				'Gidugu' => 'googlefonts',
				'Gilda Display' => 'googlefonts',
				'Give You Glory' => 'googlefonts',
				'Glass Antiqua' => 'googlefonts',
				'Glegoo' => 'googlefonts',
				'Gloria Hallelujah' => 'googlefonts',
				'Goblin One' => 'googlefonts',
				'Gochi Hand' => 'googlefonts',
				'Gorditas' => 'googlefonts',
				'Goudy Bookletter 1911' => 'googlefonts',
				'Graduate' => 'googlefonts',
				'Grand Hotel' => 'googlefonts',
				'Gravitas One' => 'googlefonts',
				'Great Vibes' => 'googlefonts',
				'Griffy' => 'googlefonts',
				'Gruppo' => 'googlefonts',
				'Gudea' => 'googlefonts',
				'Gurajada' => 'googlefonts',
				'Habibi' => 'googlefonts',
				'Halant' => 'googlefonts',
				'Hammersmith One' => 'googlefonts',
				'Hanalei' => 'googlefonts',
				'Hanalei Fill' => 'googlefonts',
				'Handlee' => 'googlefonts',
				'Hanuman' => 'googlefonts',
				'Happy Monkey' => 'googlefonts',
				'Harmattan' => 'googlefonts',
				'Headland One' => 'googlefonts',
				'Heebo' => 'googlefonts',
				'Henny Penny' => 'googlefonts',
				'Herr Von Muellerhoff' => 'googlefonts',
				'Hind' => 'googlefonts',
				'Hind Guntur' => 'googlefonts',
				'Hind Madurai' => 'googlefonts',
				'Hind Siliguri' => 'googlefonts',
				'Hind Vadodara' => 'googlefonts',
				'Holtwood One SC' => 'googlefonts',
				'Homemade Apple' => 'googlefonts',
				'Homenaje' => 'googlefonts',
				'IM Fell DW Pica' => 'googlefonts',
				'IM Fell DW Pica SC' => 'googlefonts',
				'IM Fell Double Pica' => 'googlefonts',
				'IM Fell Double Pica SC' => 'googlefonts',
				'IM Fell English' => 'googlefonts',
				'IM Fell English SC' => 'googlefonts',
				'IM Fell French Canon' => 'googlefonts',
				'IM Fell French Canon SC' => 'googlefonts',
				'IM Fell Great Primer' => 'googlefonts',
				'IM Fell Great Primer SC' => 'googlefonts',
				'Iceberg' => 'googlefonts',
				'Iceland' => 'googlefonts',
				'Imprima' => 'googlefonts',
				'Inconsolata' => 'googlefonts',
				'Inder' => 'googlefonts',
				'Indie Flower' => 'googlefonts',
				'Inika' => 'googlefonts',
				'Inknut Antiqua' => 'googlefonts',
				'Irish Grover' => 'googlefonts',
				'Istok Web' => 'googlefonts',
				'Italiana' => 'googlefonts',
				'Itim' => 'googlefonts',
				'Italianno' => 'googlefonts',
				'Jacques Francois' => 'googlefonts',
				'Jacques Francois Shadow' => 'googlefonts',
				'Jim Nightshade' => 'googlefonts',
				'Jaldi' => 'googlefonts',
				'Jockey One' => 'googlefonts',
				'Jolly Lodger' => 'googlefonts',
				'Jomhuria' => 'googlefonts',
				'Josefin Sans' => 'googlefonts',
				'Josefin Slab' => 'googlefonts',
				'Joti One' => 'googlefonts',
				'Judson' => 'googlefonts',
				'Julee' => 'googlefonts',
				'Julius Sans One' => 'googlefonts',
				'Junge' => 'googlefonts',
				'Jura' => 'googlefonts',
				'Just Another Hand' => 'googlefonts',
				'Just Me Again Down Here' => 'googlefonts',
				'Kalam' => 'googlefonts',
				'Kadwa' => 'googlefonts',
				'Kameron' => 'googlefonts',
				'Kantumruy' => 'googlefonts',
				'Karla' => 'googlefonts',
				'Karma' => 'googlefonts',
				'Kaushan Script' => 'googlefonts',
				'Kavoon' => 'googlefonts',
				'Kdam Thmor' => 'googlefonts',
				'Keania One' => 'googlefonts',
				'Kelly Slab' => 'googlefonts',
				'Kenia' => 'googlefonts',
				'Khand' => 'googlefonts',
				'Khmer' => 'googlefonts',
				'Khula' => 'googlefonts',
				'Kite One' => 'googlefonts',
				'Knewave' => 'googlefonts',
				'Kumar One' => 'googlefonts',
				'Kumar One Outline' => 'googlefonts',
				'Kurale' => 'googlefonts',
				'Kanit' => 'googlefonts',
				'Kotta One' => 'googlefonts',
				'Koulen' => 'googlefonts',
				'Kranky' => 'googlefonts',
				'Kreon' => 'googlefonts',
				'Katibeh' => 'googlefonts',
				'Kristi' => 'googlefonts',
				'Krona One' => 'googlefonts',
				'La Belle Aurore' => 'googlefonts',
				'Laila' => 'googlefonts',
				'Lakki Reddy' => 'googlefonts',
				'Lalezar' => 'googlefonts',
				'Lancelot' => 'googlefonts',
				'Lateef' => 'googlefonts',
				'Lato' => 'googlefonts',
				'League Script' => 'googlefonts',
				'Lemonada' => 'googlefonts',
				'Kavivanar' => 'googlefonts',
				'Leckerli One' => 'googlefonts',
				'Ledger' => 'googlefonts',
				'Lekton' => 'googlefonts',
				'Lemon' => 'googlefonts',
				'Libre Baskerville' => 'googlefonts',
				'Libre Franklin' => 'googlefonts',
				'Life Savers' => 'googlefonts',
				'Lilita One' => 'googlefonts',
				'Lily Script One' => 'googlefonts',
				'Limelight' => 'googlefonts',
				'Linden Hill' => 'googlefonts',
				'Lobster' => 'googlefonts',
				'Lobster Two' => 'googlefonts',
				'Londrina Outline' => 'googlefonts',
				'Londrina Shadow' => 'googlefonts',
				'Londrina Sketch' => 'googlefonts',
				'Londrina Solid' => 'googlefonts',
				'Lora' => 'googlefonts',
				'Love Ya Like A Sister' => 'googlefonts',
				'Loved by the King' => 'googlefonts',
				'Lovers Quarrel' => 'googlefonts',
				'Luckiest Guy' => 'googlefonts',
				'Lusitana' => 'googlefonts',
				'Lustria' => 'googlefonts',
				'Macondo' => 'googlefonts',
				'Macondo Swash Caps' => 'googlefonts',
				'Mada' => 'googlefonts',
				'Magra' => 'googlefonts',
				'Maiden Orange' => 'googlefonts',
				'Maitree' => 'googlefonts',
				'Mako' => 'googlefonts',
				'Mallanna' => 'googlefonts',
				'Mandali' => 'googlefonts',
				'Marcellus' => 'googlefonts',
				'Marcellus SC' => 'googlefonts',
				'Marck Script' => 'googlefonts',
				'Margarine' => 'googlefonts',
				'Marko One' => 'googlefonts',
				'Marmelad' => 'googlefonts',
				'Martel' => 'googlefonts',
				'Martel Sans' => 'googlefonts',
				'Marvel' => 'googlefonts',
				'Mate' => 'googlefonts',
				'Mate SC' => 'googlefonts',
				'Maven Pro' => 'googlefonts',
				'McLaren' => 'googlefonts',
				'Meddon' => 'googlefonts',
				'MedievalSharp' => 'googlefonts',
				'Medula One' => 'googlefonts',
				'Meera Inimai' => 'googlefonts',
				'Megrim' => 'googlefonts',
				'Meie Script' => 'googlefonts',
				'Merienda' => 'googlefonts',
				'Merienda One' => 'googlefonts',
				'Merriweather' => 'googlefonts',
				'Merriweather Sans' => 'googlefonts',
				'Metal' => 'googlefonts',
				'Metal Mania' => 'googlefonts',
				'Metamorphous' => 'googlefonts',
				'Metrophobic' => 'googlefonts',
				'Michroma' => 'googlefonts',
				'Milonga' => 'googlefonts',
				'Miltonian' => 'googlefonts',
				'Miltonian Tattoo' => 'googlefonts',
				'Miniver' => 'googlefonts',
				'Miss Fajardose' => 'googlefonts',
				'Miriam Libre' => 'googlefonts',
				'Mirza' => 'googlefonts',
				'Mitr' => 'googlefonts',
				'Modak' => 'googlefonts',
				'Mogra' => 'googlefonts',
				'Modern Antiqua' => 'googlefonts',
				'Molengo' => 'googlefonts',
				'Molle' => 'googlefonts',
				'Monda' => 'googlefonts',
				'Monofett' => 'googlefonts',
				'Monoton' => 'googlefonts',
				'Monsieur La Doulaise' => 'googlefonts',
				'Montaga' => 'googlefonts',
				'Montez' => 'googlefonts',
				'Montserrat' => 'googlefonts',
				'Montserrat Alternates' => 'googlefonts',
				'Montserrat Subrayada' => 'googlefonts',
				'Moul' => 'googlefonts',
				'Moulpali' => 'googlefonts',
				'Mountains of Christmas' => 'googlefonts',
				'Mouse Memoirs' => 'googlefonts',
				'Mr Bedfort' => 'googlefonts',
				'Mr Dafoe' => 'googlefonts',
				'Mr De Haviland' => 'googlefonts',
				'Mrs Saint Delafield' => 'googlefonts',
				'Mrs Sheppards' => 'googlefonts',
				'Mukta Vaani' => 'googlefonts',
				'Muli' => 'googlefonts',
				'Mystery Quest' => 'googlefonts',
				'NTR' => 'googlefonts',
				'Neucha' => 'googlefonts',
				'Neuton' => 'googlefonts',
				'New Rocker' => 'googlefonts',
				'News Cycle' => 'googlefonts',
				'Niconne' => 'googlefonts',
				'Nixie One' => 'googlefonts',
				'Nobile' => 'googlefonts',
				'Nokora' => 'googlefonts',
				'Norican' => 'googlefonts',
				'Nosifer' => 'googlefonts',
				'Nothing You Could Do' => 'googlefonts',
				'Noticia Text' => 'googlefonts',
				'Noto Sans' => 'googlefonts',
				'Noto Sans Hebrew' => 'earlyaccess',
				'Noto Serif' => 'googlefonts',
				'Noto Kufi Arabic' => 'earlyaccess',
				'Noto Naskh Arabic' => 'earlyaccess',
				'Nova Cut' => 'googlefonts',
				'Nova Flat' => 'googlefonts',
				'Nova Mono' => 'googlefonts',
				'Nova Oval' => 'googlefonts',
				'Nova Round' => 'googlefonts',
				'Nova Script' => 'googlefonts',
				'Nova Slim' => 'googlefonts',
				'Nova Square' => 'googlefonts',
				'Numans' => 'googlefonts',
				'Nunito' => 'googlefonts',
				'Odor Mean Chey' => 'googlefonts',
				'Offside' => 'googlefonts',
				'Old Standard TT' => 'googlefonts',
				'Oldenburg' => 'googlefonts',
				'Oleo Script' => 'googlefonts',
				'Oleo Script Swash Caps' => 'googlefonts',
				'Open Sans' => 'googlefonts',
				'Open Sans Hebrew' => 'local',
				'Open Sans Condensed' => 'googlefonts',
				'Open Sans Hebrew Condensed' => 'local',
				'Oranienbaum' => 'googlefonts',
				'Orbitron' => 'googlefonts',
				'Oregano' => 'googlefonts',
				'Orienta' => 'googlefonts',
				'Original Surfer' => 'googlefonts',
				'Oswald' => 'googlefonts',
				'Over the Rainbow' => 'googlefonts',
				'Overlock' => 'googlefonts',
				'Overlock SC' => 'googlefonts',
				'Ovo' => 'googlefonts',
				'Oxygen' => 'googlefonts',
				'Oxygen Mono' => 'googlefonts',
				'PT Mono' => 'googlefonts',
				'PT Sans' => 'googlefonts',
				'PT Sans Caption' => 'googlefonts',
				'PT Sans Narrow' => 'googlefonts',
				'PT Serif' => 'googlefonts',
				'PT Serif Caption' => 'googlefonts',
				'Pacifico' => 'googlefonts',
				'Palanquin' => 'googlefonts',
				'Paprika' => 'googlefonts',
				'Parisienne' => 'googlefonts',
				'Passero One' => 'googlefonts',
				'Passion One' => 'googlefonts',
				'Pathway Gothic One' => 'googlefonts',
				'Patrick Hand' => 'googlefonts',
				'Patrick Hand SC' => 'googlefonts',
				'Pattaya' => 'googlefonts',
				'Patua One' => 'googlefonts',
				'Paytone One' => 'googlefonts',
				'Peddana' => 'googlefonts',
				'Pavanam' => 'googlefonts',
				'Peralta' => 'googlefonts',
				'Permanent Marker' => 'googlefonts',
				'Petit Formal Script' => 'googlefonts',
				'Petrona' => 'googlefonts',
				'Philosopher' => 'googlefonts',
				'Piedra' => 'googlefonts',
				'Pinyon Script' => 'googlefonts',
				'Pirata One' => 'googlefonts',
				'Plaster' => 'googlefonts',
				'Play' => 'googlefonts',
				'Playball' => 'googlefonts',
				'Playfair Display' => 'googlefonts',
				'Playfair Display SC' => 'googlefonts',
				'Podkova' => 'googlefonts',
				'Poiret One' => 'googlefonts',
				'Poppins' => 'googlefonts',
				'Poller One' => 'googlefonts',
				'Poly' => 'googlefonts',
				'Pompiere' => 'googlefonts',
				'Pontano Sans' => 'googlefonts',
				'Port Lligat Sans' => 'googlefonts',
				'Port Lligat Slab' => 'googlefonts',
				'Pragati Narrow' => 'googlefonts',
				'Prata' => 'googlefonts',
				'Preahvihear' => 'googlefonts',
				'Press Start 2P' => 'googlefonts',
				'Pridi' => 'googlefonts',
				'Princess Sofia' => 'googlefonts',
				'Prociono' => 'googlefonts',
				'Prosto One' => 'googlefonts',
				'Prompt' => 'googlefonts',
				'Proza Libre' => 'googlefonts',
				'Rakkas' => 'googlefonts',
				'Puritan' => 'googlefonts',
				'Purple Purse' => 'googlefonts',
				'Quando' => 'googlefonts',
				'Quantico' => 'googlefonts',
				'Quattrocento' => 'googlefonts',
				'Quattrocento Sans' => 'googlefonts',
				'Questrial' => 'googlefonts',
				'Quicksand' => 'googlefonts',
				'Quintessential' => 'googlefonts',
				'Qwigley' => 'googlefonts',
				'Racing Sans One' => 'googlefonts',
				'Radley' => 'googlefonts',
				'Ranga' => 'googlefonts',
				'Rasa' => 'googlefonts',
				'Reem Kufi' => 'googlefonts',
				'Rhodium Libre' => 'googlefonts',
				'Rajdhani' => 'googlefonts',
				'Raleway' => 'googlefonts',
				'Raleway Dots' => 'googlefonts',
				'Ramabhadra' => 'googlefonts',
				'Ramaraja' => 'googlefonts',
				'Rambla' => 'googlefonts',
				'Rammetto One' => 'googlefonts',
				'Ranchers' => 'googlefonts',
				'Rancho' => 'googlefonts',
				'Rationale' => 'googlefonts',
				'Ravi Prakash' => 'googlefonts',
				'Redressed' => 'googlefonts',
				'Reenie Beanie' => 'googlefonts',
				'Revalia' => 'googlefonts',
				'Ribeye' => 'googlefonts',
				'Ribeye Marrow' => 'googlefonts',
				'Righteous' => 'googlefonts',
				'Risque' => 'googlefonts',
				'Roboto' => 'googlefonts',
				'Roboto Condensed' => 'googlefonts',
				'Roboto Mono' => 'googlefonts',
				'Roboto Slab' => 'googlefonts',
				'Rochester' => 'googlefonts',
				'Rock Salt' => 'googlefonts',
				'Rokkitt' => 'googlefonts',
				'Romanesco' => 'googlefonts',
				'Ropa Sans' => 'googlefonts',
				'Rosario' => 'googlefonts',
				'Rosarivo' => 'googlefonts',
				'Rouge Script' => 'googlefonts',
				'Rozha One' => 'googlefonts',
				'Rubik' => 'googlefonts',
				'Rubik Mono One' => 'googlefonts',
				'Rubik One' => 'googlefonts',
				'Ruda' => 'googlefonts',
				'Rufina' => 'googlefonts',
				'Ruge Boogie' => 'googlefonts',
				'Ruluko' => 'googlefonts',
				'Rum Raisin' => 'googlefonts',
				'Ruslan Display' => 'googlefonts',
				'Russo One' => 'googlefonts',
				'Ruthie' => 'googlefonts',
				'Rye' => 'googlefonts',
				'Sacramento' => 'googlefonts',
				'Sahitya' => 'googlefonts',
				'Sail' => 'googlefonts',
				'Salsa' => 'googlefonts',
				'Sanchez' => 'googlefonts',
				'Sancreek' => 'googlefonts',
				'Sansita One' => 'googlefonts',
				'Sarina' => 'googlefonts',
				'Sarpanch' => 'googlefonts',
				'Satisfy' => 'googlefonts',
				'Scada' => 'googlefonts',
				'Scheherazade' => 'googlefonts',
				'Schoolbell' => 'googlefonts',
				'Scope One' => 'googlefonts',
				'Seaweed Script' => 'googlefonts',
				'Secular One' => 'googlefonts',
				'Sarala' => 'googlefonts',
				'Sevillana' => 'googlefonts',
				'Seymour One' => 'googlefonts',
				'Shadows Into Light' => 'googlefonts',
				'Shadows Into Light Two' => 'googlefonts',
				'Shanti' => 'googlefonts',
				'Share' => 'googlefonts',
				'Share Tech' => 'googlefonts',
				'Share Tech Mono' => 'googlefonts',
				'Shojumaru' => 'googlefonts',
				'Short Stack' => 'googlefonts',
				'Shrikhand' => 'googlefonts',
				'Siemreap' => 'googlefonts',
				'Sigmar One' => 'googlefonts',
				'Signika' => 'googlefonts',
				'Signika Negative' => 'googlefonts',
				'Simonetta' => 'googlefonts',
				'Sintony' => 'googlefonts',
				'Sirin Stencil' => 'googlefonts',
				'Six Caps' => 'googlefonts',
				'Skranji' => 'googlefonts',
				'Slabo 13px' => 'googlefonts',
				'Slabo 27px' => 'googlefonts',
				'Slackey' => 'googlefonts',
				'Smokum' => 'googlefonts',
				'Smythe' => 'googlefonts',
				'Sniglet' => 'googlefonts',
				'Snippet' => 'googlefonts',
				'Snowburst One' => 'googlefonts',
				'Sofadi One' => 'googlefonts',
				'Sofia' => 'googlefonts',
				'Sonsie One' => 'googlefonts',
				'Sorts Mill Goudy' => 'googlefonts',
				'Source Code Pro' => 'googlefonts',
				'Source Sans Pro' => 'googlefonts',
				'Source Serif Pro' => 'googlefonts',
				'Special Elite' => 'googlefonts',
				'Spicy Rice' => 'googlefonts',
				'Spinnaker' => 'googlefonts',
				'Spirax' => 'googlefonts',
				'Squada One' => 'googlefonts',
				'Sree Krushnadevaraya' => 'googlefonts',
				'Stalemate' => 'googlefonts',
				'Stalinist One' => 'googlefonts',
				'Stardos Stencil' => 'googlefonts',
				'Stint Ultra Condensed' => 'googlefonts',
				'Stint Ultra Expanded' => 'googlefonts',
				'Stoke' => 'googlefonts',
				'Strait' => 'googlefonts',
				'Sue Ellen Francisco' => 'googlefonts',
				'Suez One' => 'googlefonts',
				'Sunshiney' => 'googlefonts',
				'Supermercado One' => 'googlefonts',
				'Space Mono' => 'googlefonts',
				'Sriracha' => 'googlefonts',
				'Sumana' => 'googlefonts',
				'Suranna' => 'googlefonts',
				'Suravaram' => 'googlefonts',
				'Suwannaphum' => 'googlefonts',
				'Sura' => 'googlefonts',
				'Swanky and Moo Moo' => 'googlefonts',
				'Syncopate' => 'googlefonts',
				'Tangerine' => 'googlefonts',
				'Taprom' => 'googlefonts',
				'Tauri' => 'googlefonts',
				'Taviraj' => 'googlefonts',
				'Teko' => 'googlefonts',
				'Telex' => 'googlefonts',
				'Tenali Ramakrishna' => 'googlefonts',
				'Tenor Sans' => 'googlefonts',
				'Text Me One' => 'googlefonts',
				'The Girl Next Door' => 'googlefonts',
				'Tienne' => 'googlefonts',
				'Tillana' => 'googlefonts',
				'Timmana' => 'googlefonts',
				'Tinos' => 'googlefonts',
				'Titan One' => 'googlefonts',
				'Titillium Web' => 'googlefonts',
				'Trade Winds' => 'googlefonts',
				'Trocchi' => 'googlefonts',
				'Trochut' => 'googlefonts',
				'Trirong' => 'googlefonts',
				'Trykker' => 'googlefonts',
				'Tulpen One' => 'googlefonts',
				'Ubuntu' => 'googlefonts',
				'Ubuntu Condensed' => 'googlefonts',
				'Ubuntu Mono' => 'googlefonts',
				'Ultra' => 'googlefonts',
				'Uncial Antiqua' => 'googlefonts',
				'Underdog' => 'googlefonts',
				'Unica One' => 'googlefonts',
				'UnifrakturCook' => 'googlefonts',
				'UnifrakturMaguntia' => 'googlefonts',
				'Unkempt' => 'googlefonts',
				'Unlock' => 'googlefonts',
				'Unna' => 'googlefonts',
				'VT323' => 'googlefonts',
				'Vampiro One' => 'googlefonts',
				'Varela' => 'googlefonts',
				'Varela Round' => 'googlefonts',
				'Vast Shadow' => 'googlefonts',
				'Vesper Libre' => 'googlefonts',
				'Vibur' => 'googlefonts',
				'Vidaloka' => 'googlefonts',
				'Viga' => 'googlefonts',
				'Voces' => 'googlefonts',
				'Volkhov' => 'googlefonts',
				'Vollkorn' => 'googlefonts',
				'Voltaire' => 'googlefonts',
				'Waiting for the Sunrise' => 'googlefonts',
				'Wallpoet' => 'googlefonts',
				'Walter Turncoat' => 'googlefonts',
				'Warnes' => 'googlefonts',
				'Wellfleet' => 'googlefonts',
				'Wendy One' => 'googlefonts',
				'Wire One' => 'googlefonts',
				'Work Sans' => 'googlefonts',
				'Yanone Kaffeesatz' => 'googlefonts',
				'Yantramanav' => 'googlefonts',
				'Yatra One' => 'googlefonts',
				'Yellowtail' => 'googlefonts',
				'Yeseva One' => 'googlefonts',
				'Yesteryear' => 'googlefonts',
				'Yrsa' => 'googlefonts',
				'Zeyada' => 'googlefonts',
			)
		);
	}
	
	public static function get_web_fonts() {
		self::_build_font_faces();
		return self::$_font_faces;
	}
	
	public static function get_font_type( $name ) {
		self::_build_font_faces();
		
		if ( empty( self::$_font_faces[ $name ] ) )
			return false;
		
		return self::$_font_faces[ $name ];
	}
}