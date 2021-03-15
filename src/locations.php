<?php
/********************
 *
 *	@file : locations.php
 *	@author : La Drome laboratoire
 *	@version: 1.0.0
 *	@Date: 06/03/2021
 *	@license GPL
 *
 *	Méthodes de conversion de coordonnées géographiques et de calculs divers
 *
 *
 ********************/ 
namespace ladromelaboratoire\tools;

class locations {
	private const __demi_grand_axe = 6378137; //exprimé en mètres
	private const __applatissement_terrestre = 1 / 298.257222101;
	private const __long_0 = 3;
	private const __lat_0 = 46.5;
	private const __lambert_x0 = 700000;
	private const __lambert_y0 = 6600000;
	private const __xs = 700000; // semble être __lambert_x0
	private const __ys = 12655612.0499; //n'ai pas trouvé le lien avec __lambert_y0
	private const __n = 0.7256077650532670;
	private const __c = 11754255.426096;
	private const __decimal_format = 10;
	private const __180deg = 180;
	private const __premiere_exent_ellipse_wgs84 = 0.08181919106;
	
	
	/*******
	* Conversion de GPS WGS84 vers Lambert 93
	* in: x_lambert93, y_lambert93
	* out: tableau
	*		- xLambert93
	*		- yLambert93
	*		- latitude degrés décimaux
	*		- longitude degrés décimaux
	*******/
	public static function lambert93ToWgs84($xl93, $yl93) {
		$b8  = self::__applatissement_terrestre;
		$b10 = sqrt(2 * self::__applatissement_terrestre - self::__applatissement_terrestre * self::__applatissement_terrestre);

		$xl93calc = number_format(floatval($xl93), self::__decimal_format, '.', '') - self::__lambert_x0;
		$yl93calc = number_format(floatval($yl93), self::__decimal_format, '.', '') - self::__ys;
		$gamma = atan(-$xl93calc / $yl93calc);
		$latiso = log(self::__c / sqrt(($xl93calc * $xl93calc) + ($yl93calc * $yl93calc))) / self::__n;
		$sinphiit = tanh($latiso + $b10 * atanh($b10 * sin(1)));

		for ($i = 0; $i != 6 ; $i++) {
			$sinphiit = tanh($latiso + $b10 * atanh($b10 * $sinphiit));
		}
		return (array(
			'xl93' => $xl93,
			'yl93' => $yl93,
			'lat' => asin($sinphiit) / pi() * self::__180deg,
			'long' => ($gamma / self::__n + self::__long_0 / self::__180deg * pi()) / pi() * self::__180deg
		));
	}
	/*******
	* Conversion de Lambert93 vers GPS WGS84
	* in: latitude, longitude
	* out: tableau
	*		- xLambert93
	*		- yLambert93
	*		- latitude degrés décimaux
	*		- longitude degrés décimaux
	*
	* Méthode de calcul pour une projection de type lambert conique conforme sécante (NTG_71.pdf):
	* https://geodesie.ign.fr/contenu/fichiers/documentation/algorithmes/notice/NTG_71.pdf
	*
	*******/
	public static function wsg84ToLambert93 ($lat,$long) {

		//paramtres de projections
		$l0=$lc=deg2rad(self::__long_0); //longitude de réfrence
		$phi0=deg2rad(self::__lat_0); //latitude d'origine en radian
		$phi1=deg2rad(44); //1er parallele automcoque
		$phi2=deg2rad(49); //2eme parallele automcoque

		//coordonnes du point traduire en radian
		$phi=deg2rad($lat);
		$l=deg2rad($long);

		//calcul des grandes normales
		$gN1= self::__demi_grand_axe / sqrt(1 - pow(self::__premiere_exent_ellipse_wgs84, 2) * sin($phi1) * sin($phi1));
		$gN2= self::__demi_grand_axe / sqrt(1 - pow(self::__premiere_exent_ellipse_wgs84, 2) * sin($phi2) * sin($phi2));

		//calculs de latitudes isométriques
		$gl1=log(tan(pi()/4+$phi1/2) * pow((1-self::__premiere_exent_ellipse_wgs84*sin($phi1))/(1+self::__premiere_exent_ellipse_wgs84*sin($phi1)),self::__premiere_exent_ellipse_wgs84/2));
		$gl2=log(tan(pi()/4+$phi2/2) * pow((1-self::__premiere_exent_ellipse_wgs84*sin($phi2))/(1+self::__premiere_exent_ellipse_wgs84*sin($phi2)),self::__premiere_exent_ellipse_wgs84/2));
		$gl0=log(tan(pi()/4+$phi0/2) * pow((1-self::__premiere_exent_ellipse_wgs84*sin($phi0))/(1+self::__premiere_exent_ellipse_wgs84*sin($phi0)),self::__premiere_exent_ellipse_wgs84/2));
		$gl= log(tan(pi()/4+$phi/2) * pow((1-self::__premiere_exent_ellipse_wgs84*sin($phi))/(1+self::__premiere_exent_ellipse_wgs84*sin($phi)),self::__premiere_exent_ellipse_wgs84/2));

		//calcul de l'exposant de la projection
		$n=(log(($gN2*Cos($phi2))/($gN1*cos($phi1))))/($gl1-$gl2);

		//calcul de la constante de projection
		$c=(($gN1*cos($phi1))/$n)*exp($n*$gl1);

		//calcul des coordonnes
		$ys=self::__lambert_y0+$c*exp(-1*$n*$gl0);

		//calcul des coordonnes lambert
		$xl93=self::__lambert_x0+$c*exp(-1*$n*$gl)*sin($n*($l-$lc));
		$yl93=$ys-$c*exp(-1*$n*$gl)*cos($n*($l-$lc));
		
		//Retour
		return (array(
			'xl93' => $xl93,
			'yl93' => $yl93,
			'lat' => $lat,
			'long' => $long
		));
	}
	/*******
	* Calcul de distance et azimut
	* in: tableau point 1 (lat, long)
	*     tableau point 2 (lat, long)
	* out:
	*     False si erreur
	*     tableau
	*		- tableau point 1
	*		- tableau point 2
	*		- Distance en mètres
	*		- Azimut en dégrés
	*******/	
	public static function distance2Points ($point1, $point2) {

		$error = false;
		if (is_array($point1) && array_key_exists('long', $point1) && array_key_exists('lat', $point1)) {
			$lat1 = deg2rad($point1['lat']);
			$long1 = deg2rad($point1['long']);
		}
		else {
			$error = true;
		}
		if (is_array($point2) && array_key_exists('long', $point2) && array_key_exists('lat', $point2)) {
			$lat2 = deg2rad($point2['lat']);
			$long2 = deg2rad($point2['long']);
		}
		else {
			$error = true;
		}
		//si erreur, retour de false
		if ($error) return !$error;
		
		//distance
		$dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($long2 - $long1)) * self::__demi_grand_axe;
		
		//azimut
		$x = cos($lat1) * sin($lat2) - cos($lat2) * sin($lat1) * cos ($long2 - $long1);
		$y = sin ($long2 - $long1) * cos ($lat2);

		$azimut = self::__180deg * atan2($y, $x) / pi();
		if ($azimut < 0) $azimut += 2 * self::__180deg;
		
		return (array(
			'point1' => $point1,
			'point2' => $point2,
			'dist' => $dist,
			'azimut' => $azimut
		));
	}
}
?>