<?php
/**
 * HR Engine: User profile fields (user meta). Used for Create Profile and My Profile.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * My Profile URL (with optional apply_to for clean URL).
 *
 * @param int $job_id Optional job ID for apply flow.
 * @return string
 */
function tasheel_hr_my_profile_url( $job_id = 0 ) {
	if ( $job_id ) {
		return home_url( '/my-profile/apply/' . (int) $job_id . '/' );
	}
	return home_url( '/my-profile/' );
}

/**
 * Create Profile URL (with optional apply_to for clean URL).
 *
 * @param int $job_id Optional job ID for apply flow.
 * @return string
 */
function tasheel_hr_create_profile_url( $job_id = 0 ) {
	if ( $job_id ) {
		return home_url( '/create-profile/apply/' . (int) $job_id . '/' );
	}
	return home_url( '/create-profile/' );
}

/**
 * URL for the Create Profile page when editing (from Review Profile). Always includes ?edit=1 so the form loads existing data.
 *
 * @param int $job_id Optional job ID for apply flow (0 = no apply context).
 * @return string
 */
function tasheel_hr_edit_profile_url( $job_id = 0 ) {
	$base = $job_id ? home_url( '/create-profile/apply/' . (int) $job_id . '/' ) : home_url( '/create-profile/' );
	return add_query_arg( 'edit', '1', $base );
}

/**
 * Redirect URLs for login popup (used in header). When on job page, include apply_to. Uses redirect_to from request when present (e.g. after "login required" sent user to homepage).
 *
 * @return array{login: string, register: string}
 */
function tasheel_hr_popup_redirect_urls() {
	$login_url   = home_url( '/my-profile/' );
	$register_url = home_url( '/create-profile/' );
	// If user was sent to homepage with ?redirect_to= (e.g. from my-profile when not logged in), use that after login.
	if ( ! empty( $_GET['redirect_to'] ) ) {
		$requested = esc_url_raw( wp_unslash( $_GET['redirect_to'] ) );
		if ( $requested ) {
			$login_url = ( strpos( $requested, 'http' ) === 0 ) ? $requested : home_url( $requested );
			if ( strpos( $login_url, home_url() ) !== 0 ) {
				$login_url = home_url( '/my-profile/' );
			}
		}
	}
	if ( is_singular( 'hr_job' ) && function_exists( 'get_the_ID' ) ) {
		$job_id = get_the_ID();
		if ( $job_id ) {
			$login_url   = tasheel_hr_my_profile_url( $job_id );
			$register_url = tasheel_hr_create_profile_url( $job_id );
		}
	}
	return array( 'login' => $login_url, 'register' => $register_url );
}

/**
 * Generate a thumbnail image from uploaded PDF (first page). Returns thumbnail URL or false.
 * Requires Imagick and Ghostscript. For images (jpg,png) returns false (use original).
 *
 * @param string $file_path Full path to uploaded file.
 * @param string $ext       File extension (pdf, doc, docx, jpg, etc.).
 * @return string|false Thumbnail URL on success, false otherwise.
 */
function tasheel_hr_generate_document_thumbnail( $file_path, $ext ) {
	if ( ! is_file( $file_path ) ) {
		return false;
	}
	$ext = strtolower( $ext );
	// Images: no thumbnail needed, frontend uses original.
	if ( in_array( $ext, array( 'jpg', 'jpeg', 'png', 'gif', 'webp' ), true ) ) {
		return false;
	}
	// PDF: try Imagick to render first page.
	if ( 'pdf' !== $ext ) {
		return false; // DOC/DOCX require LibreOffice or similar - skip.
	}
	if ( ! class_exists( 'Imagick' ) ) {
		return false;
	}
	try {
		$im = new Imagick();
		$im->setResolution( 150, 150 );
		$im->readImage( $file_path . '[0]' );
		$im->setIteratorIndex( 0 );
		$im->setImageFormat( 'jpg' );
		$im->setImageCompressionQuality( 85 );
		$im->thumbnailImage( 400, 0, false ); // Max width 400, keep aspect.
		$dir  = dirname( $file_path );
		$base = pathinfo( $file_path, PATHINFO_FILENAME );
		$thumb_path = $dir . '/' . $base . '-thumb.jpg';
		if ( $im->writeImage( $thumb_path ) ) {
			$im->clear();
			$im->destroy();
			$upload_dir = wp_upload_dir();
			if ( ! empty( $upload_dir['baseurl'] ) && ! empty( $upload_dir['basedir'] ) && strpos( $thumb_path, $upload_dir['basedir'] ) === 0 ) {
				$rel = substr( $thumb_path, strlen( $upload_dir['basedir'] ) + 1 );
				return $upload_dir['baseurl'] . '/' . str_replace( '\\', '/', $rel );
			}
			return false;
		}
		$im->clear();
		$im->destroy();
	} catch ( Exception $e ) {
		// Imagick failed (e.g. Ghostscript missing) - silently return false.
	}
	return false;
}

/**
 * Current language code for country/nationality list (WPML or locale). 'ar' = Arabic, else English.
 *
 * @return string 'ar' or 'en'
 */
function tasheel_hr_get_country_list_language() {
	if ( function_exists( 'apply_filters' ) ) {
		$wpml_lang = apply_filters( 'wpml_current_language', null );
		if ( is_string( $wpml_lang ) && $wpml_lang !== '' ) {
			return ( strpos( $wpml_lang, 'ar' ) === 0 ) ? 'ar' : 'en';
		}
	}
	$locale = function_exists( 'get_locale' ) ? get_locale() : '';
	return ( $locale === 'ar' || strpos( (string) $locale, 'ar_' ) === 0 ) ? 'ar' : 'en';
}

/**
 * Country names in Arabic (ISO 3166-1 alpha-2 => Arabic name). Used when current language is Arabic.
 *
 * @return array<string, string>
 */
function tasheel_hr_get_countries_arabic() {
	static $countries = null;
	if ( $countries === null ) {
		$countries = array(
			'AF' => 'أفغانستان', 'AL' => 'ألبانيا', 'DZ' => 'الجزائر', 'AD' => 'أندورا', 'AO' => 'أنغولا',
			'AR' => 'الأرجنتين', 'AM' => 'أرمينيا', 'AU' => 'أستراليا', 'AT' => 'النمسا', 'AZ' => 'أذربيجان',
			'BH' => 'البحرين', 'BD' => 'بنغلاديش', 'BB' => 'بربادوس', 'BY' => 'بيلاروسيا', 'BE' => 'بلجيكا',
			'BZ' => 'بليز', 'BJ' => 'بنين', 'BT' => 'بوتان', 'BO' => 'بوليفيا', 'BA' => 'البوسنة والهرسك',
			'BW' => 'بوتسوانا', 'BR' => 'البرازيل', 'BN' => 'بروناي', 'BG' => 'بلغاريا', 'BF' => 'بوركينا فاسو',
			'BI' => 'بوروندي', 'KH' => 'كمبوديا', 'CM' => 'الكاميرون', 'CA' => 'كندا', 'CV' => 'الرأس الأخضر',
			'CF' => 'جمهورية أفريقيا الوسطى', 'TD' => 'تشاد', 'CL' => 'تشيلي', 'CN' => 'الصين',
			'CO' => 'كولومبيا', 'KM' => 'جزر القمر', 'CG' => 'الكونغو', 'CR' => 'كوستاريكا', 'CI' => 'ساحل العاج',
			'HR' => 'كرواتيا', 'CU' => 'كوبا', 'CY' => 'قبرص', 'CZ' => 'التشيك', 'DK' => 'الدنمارك',
			'DJ' => 'جيبوتي', 'DM' => 'دومينيكا', 'DO' => 'جمهورية الدومينيكان', 'EC' => 'الإكوادور',
			'EG' => 'مصر', 'SV' => 'السلفادور', 'GQ' => 'غينيا الاستوائية', 'ER' => 'إريتريا',
			'EE' => 'إستونيا', 'SZ' => 'إسواتيني', 'ET' => 'إثيوبيا', 'FJ' => 'فيجي', 'FI' => 'فنلندا',
			'FR' => 'فرنسا', 'GA' => 'الغابون', 'GM' => 'غامبيا', 'GE' => 'جورجيا', 'DE' => 'ألمانيا',
			'GH' => 'غانا', 'GR' => 'اليونان', 'GD' => 'غرينادا', 'GT' => 'غواتيمالا', 'GN' => 'غينيا',
			'GW' => 'غينيا بيساو', 'GY' => 'غيانا', 'HT' => 'هايتي', 'HN' => 'هندوراس', 'HK' => 'هونغ كونغ',
			'HU' => 'المجر', 'IS' => 'آيسلندا', 'IN' => 'الهند', 'ID' => 'إندونيسيا', 'IR' => 'إيران',
			'IQ' => 'العراق', 'IE' => 'أيرلندا', 'IL' => 'إسرائيل', 'IT' => 'إيطاليا', 'JM' => 'جامايكا',
			'JP' => 'اليابان', 'JO' => 'الأردن', 'KZ' => 'كازاخستان', 'KE' => 'كينيا', 'KW' => 'الكويت',
			'KG' => 'قيرغيزستان', 'LA' => 'لاوس', 'LV' => 'لاتفيا', 'LB' => 'لبنان', 'LS' => 'ليسوتو',
			'LR' => 'ليبيريا', 'LY' => 'ليبيا', 'LI' => 'ليختنشتاين', 'LT' => 'ليتوانيا', 'LU' => 'لوكسمبورغ',
			'MG' => 'مدغشقر', 'MW' => 'ملاوي', 'MY' => 'ماليزيا', 'MV' => 'المالديف', 'ML' => 'مالي',
			'MT' => 'مالطا', 'MR' => 'موريتانيا', 'MU' => 'موريشيوس', 'MX' => 'المكسيك', 'MD' => 'مولدوفا',
			'MC' => 'موناكو', 'MN' => 'منغوليا', 'ME' => 'الجبل الأسود', 'MA' => 'المغرب', 'MZ' => 'موزمبيق',
			'MM' => 'ميانمار', 'NA' => 'ناميبيا', 'NP' => 'نيبال', 'NL' => 'هولندا', 'NZ' => 'نيوزيلندا',
			'NI' => 'نيكاراغوا', 'NE' => 'النيجر', 'NG' => 'نيجيريا', 'KP' => 'كوريا الشمالية', 'MK' => 'مقدونيا الشمالية',
			'NO' => 'النرويج', 'OM' => 'عمان', 'PK' => 'باكستان', 'PS' => 'فلسطين', 'PA' => 'بنما',
			'PG' => 'بابوا غينيا الجديدة', 'PY' => 'باراغواي', 'PE' => 'بيرو', 'PH' => 'الفلبين',
			'PL' => 'بولندا', 'PT' => 'البرتغال', 'PR' => 'بورتوريكو', 'QA' => 'قطر', 'RO' => 'رومانيا',
			'RU' => 'روسيا', 'RW' => 'رواندا', 'SA' => 'المملكة العربية السعودية', 'SN' => 'السنغال', 'RS' => 'صربيا',
			'SC' => 'سيشل', 'SL' => 'سيراليون', 'SG' => 'سنغافورة', 'SK' => 'سلوفاكيا',
			'SI' => 'سلوفينيا', 'SO' => 'الصومال', 'ZA' => 'جنوب أفريقيا', 'KR' => 'كوريا الجنوبية',
			'SS' => 'جنوب السودان', 'ES' => 'إسبانيا', 'LK' => 'سريلانكا', 'SD' => 'السودان', 'SR' => 'سورينام',
			'SE' => 'السويد', 'CH' => 'سويسرا', 'SY' => 'سوريا', 'TW' => 'تايوان', 'TJ' => 'طاجيكستان',
			'TZ' => 'تنزانيا', 'TH' => 'تايلاند', 'TL' => 'تيمور الشرقية', 'TG' => 'توغو', 'TO' => 'تونغا',
			'TT' => 'ترينيداد وتوباغو', 'TN' => 'تونس', 'TR' => 'تركيا', 'TM' => 'تركمانستان',
			'UG' => 'أوغندا', 'UA' => 'أوكرانيا', 'AE' => 'الإمارات العربية المتحدة', 'GB' => 'المملكة المتحدة',
			'US' => 'الولايات المتحدة', 'UY' => 'أوروغواي', 'UZ' => 'أوزبكستان', 'VE' => 'فنزويلا',
			'VN' => 'فيتنام', 'YE' => 'اليمن', 'ZM' => 'زامبيا', 'ZW' => 'زيمبابوي',
		);
		asort( $countries );
	}
	return $countries;
}

/**
 * Get list of countries (ISO 3166-1 alpha-2 code => country name). For use in dropdowns.
 * Uses built-in Arabic names when current language is Arabic (WPML /ar/ or locale ar).
 *
 * @return array<string, string>
 */
function tasheel_hr_get_countries() {
	$lang = tasheel_hr_get_country_list_language();
	static $by_lang = array();
	if ( ! isset( $by_lang[ $lang ] ) ) {
		if ( $lang === 'ar' ) {
			$by_lang[ $lang ] = tasheel_hr_get_countries_arabic();
		} else {
			$by_lang[ $lang ] = array(
				'AF' => __( 'Afghanistan', 'tasheel' ), 'AL' => __( 'Albania', 'tasheel' ), 'DZ' => __( 'Algeria', 'tasheel' ), 'AD' => __( 'Andorra', 'tasheel' ), 'AO' => __( 'Angola', 'tasheel' ),
				'AR' => __( 'Argentina', 'tasheel' ), 'AM' => __( 'Armenia', 'tasheel' ), 'AU' => __( 'Australia', 'tasheel' ), 'AT' => __( 'Austria', 'tasheel' ), 'AZ' => __( 'Azerbaijan', 'tasheel' ),
				'BH' => __( 'Bahrain', 'tasheel' ), 'BD' => __( 'Bangladesh', 'tasheel' ), 'BB' => __( 'Barbados', 'tasheel' ), 'BY' => __( 'Belarus', 'tasheel' ), 'BE' => __( 'Belgium', 'tasheel' ),
				'BZ' => __( 'Belize', 'tasheel' ), 'BJ' => __( 'Benin', 'tasheel' ), 'BT' => __( 'Bhutan', 'tasheel' ), 'BO' => __( 'Bolivia', 'tasheel' ), 'BA' => __( 'Bosnia & Herzegovina', 'tasheel' ),
				'BW' => __( 'Botswana', 'tasheel' ), 'BR' => __( 'Brazil', 'tasheel' ), 'BN' => __( 'Brunei', 'tasheel' ), 'BG' => __( 'Bulgaria', 'tasheel' ), 'BF' => __( 'Burkina Faso', 'tasheel' ),
				'BI' => __( 'Burundi', 'tasheel' ), 'KH' => __( 'Cambodia', 'tasheel' ), 'CM' => __( 'Cameroon', 'tasheel' ), 'CA' => __( 'Canada', 'tasheel' ), 'CV' => __( 'Cape Verde', 'tasheel' ),
				'CF' => __( 'Central African Republic', 'tasheel' ), 'TD' => __( 'Chad', 'tasheel' ), 'CL' => __( 'Chile', 'tasheel' ), 'CN' => __( 'China', 'tasheel' ),
				'CO' => __( 'Colombia', 'tasheel' ), 'KM' => __( 'Comoros', 'tasheel' ), 'CG' => __( 'Congo', 'tasheel' ), 'CR' => __( 'Costa Rica', 'tasheel' ), 'CI' => __( 'Côte d\'Ivoire', 'tasheel' ),
				'HR' => __( 'Croatia', 'tasheel' ), 'CU' => __( 'Cuba', 'tasheel' ), 'CY' => __( 'Cyprus', 'tasheel' ), 'CZ' => __( 'Czechia', 'tasheel' ), 'DK' => __( 'Denmark', 'tasheel' ),
				'DJ' => __( 'Djibouti', 'tasheel' ), 'DM' => __( 'Dominica', 'tasheel' ), 'DO' => __( 'Dominican Republic', 'tasheel' ), 'EC' => __( 'Ecuador', 'tasheel' ),
				'EG' => __( 'Egypt', 'tasheel' ), 'SV' => __( 'El Salvador', 'tasheel' ), 'GQ' => __( 'Equatorial Guinea', 'tasheel' ), 'ER' => __( 'Eritrea', 'tasheel' ),
				'EE' => __( 'Estonia', 'tasheel' ), 'SZ' => __( 'Eswatini', 'tasheel' ), 'ET' => __( 'Ethiopia', 'tasheel' ), 'FJ' => __( 'Fiji', 'tasheel' ), 'FI' => __( 'Finland', 'tasheel' ),
				'FR' => __( 'France', 'tasheel' ), 'GA' => __( 'Gabon', 'tasheel' ), 'GM' => __( 'Gambia', 'tasheel' ), 'GE' => __( 'Georgia', 'tasheel' ), 'DE' => __( 'Germany', 'tasheel' ),
				'GH' => __( 'Ghana', 'tasheel' ), 'GR' => __( 'Greece', 'tasheel' ), 'GD' => __( 'Grenada', 'tasheel' ), 'GT' => __( 'Guatemala', 'tasheel' ), 'GN' => __( 'Guinea', 'tasheel' ),
				'GW' => __( 'Guinea-Bissau', 'tasheel' ), 'GY' => __( 'Guyana', 'tasheel' ), 'HT' => __( 'Haiti', 'tasheel' ), 'HN' => __( 'Honduras', 'tasheel' ), 'HK' => __( 'Hong Kong', 'tasheel' ),
				'HU' => __( 'Hungary', 'tasheel' ), 'IS' => __( 'Iceland', 'tasheel' ), 'IN' => __( 'India', 'tasheel' ), 'ID' => __( 'Indonesia', 'tasheel' ), 'IR' => __( 'Iran', 'tasheel' ),
				'IQ' => __( 'Iraq', 'tasheel' ), 'IE' => __( 'Ireland', 'tasheel' ), 'IL' => __( 'Israel', 'tasheel' ), 'IT' => __( 'Italy', 'tasheel' ), 'JM' => __( 'Jamaica', 'tasheel' ),
				'JP' => __( 'Japan', 'tasheel' ), 'JO' => __( 'Jordan', 'tasheel' ), 'KZ' => __( 'Kazakhstan', 'tasheel' ), 'KE' => __( 'Kenya', 'tasheel' ), 'KW' => __( 'Kuwait', 'tasheel' ),
				'KG' => __( 'Kyrgyzstan', 'tasheel' ), 'LA' => __( 'Laos', 'tasheel' ), 'LV' => __( 'Latvia', 'tasheel' ), 'LB' => __( 'Lebanon', 'tasheel' ), 'LS' => __( 'Lesotho', 'tasheel' ),
				'LR' => __( 'Liberia', 'tasheel' ), 'LY' => __( 'Libya', 'tasheel' ), 'LI' => __( 'Liechtenstein', 'tasheel' ), 'LT' => __( 'Lithuania', 'tasheel' ), 'LU' => __( 'Luxembourg', 'tasheel' ),
				'MG' => __( 'Madagascar', 'tasheel' ), 'MW' => __( 'Malawi', 'tasheel' ), 'MY' => __( 'Malaysia', 'tasheel' ), 'MV' => __( 'Maldives', 'tasheel' ), 'ML' => __( 'Mali', 'tasheel' ),
				'MT' => __( 'Malta', 'tasheel' ), 'MR' => __( 'Mauritania', 'tasheel' ), 'MU' => __( 'Mauritius', 'tasheel' ), 'MX' => __( 'Mexico', 'tasheel' ), 'MD' => __( 'Moldova', 'tasheel' ),
				'MC' => __( 'Monaco', 'tasheel' ), 'MN' => __( 'Mongolia', 'tasheel' ), 'ME' => __( 'Montenegro', 'tasheel' ), 'MA' => __( 'Morocco', 'tasheel' ), 'MZ' => __( 'Mozambique', 'tasheel' ),
				'MM' => __( 'Myanmar', 'tasheel' ), 'NA' => __( 'Namibia', 'tasheel' ), 'NP' => __( 'Nepal', 'tasheel' ), 'NL' => __( 'Netherlands', 'tasheel' ), 'NZ' => __( 'New Zealand', 'tasheel' ),
				'NI' => __( 'Nicaragua', 'tasheel' ), 'NE' => __( 'Niger', 'tasheel' ), 'NG' => __( 'Nigeria', 'tasheel' ), 'KP' => __( 'North Korea', 'tasheel' ), 'MK' => __( 'North Macedonia', 'tasheel' ),
				'NO' => __( 'Norway', 'tasheel' ), 'OM' => __( 'Oman', 'tasheel' ), 'PK' => __( 'Pakistan', 'tasheel' ), 'PS' => __( 'Palestine', 'tasheel' ), 'PA' => __( 'Panama', 'tasheel' ),
				'PG' => __( 'Papua New Guinea', 'tasheel' ), 'PY' => __( 'Paraguay', 'tasheel' ), 'PE' => __( 'Peru', 'tasheel' ), 'PH' => __( 'Philippines', 'tasheel' ),
				'PL' => __( 'Poland', 'tasheel' ), 'PT' => __( 'Portugal', 'tasheel' ), 'PR' => __( 'Puerto Rico', 'tasheel' ), 'QA' => __( 'Qatar', 'tasheel' ), 'RO' => __( 'Romania', 'tasheel' ),
				'RU' => __( 'Russia', 'tasheel' ), 'RW' => __( 'Rwanda', 'tasheel' ), 'SA' => __( 'Saudi Arabia', 'tasheel' ), 'SN' => __( 'Senegal', 'tasheel' ), 'RS' => __( 'Serbia', 'tasheel' ),
				'SC' => __( 'Seychelles', 'tasheel' ), 'SL' => __( 'Sierra Leone', 'tasheel' ), 'SG' => __( 'Singapore', 'tasheel' ), 'SK' => __( 'Slovakia', 'tasheel' ),
				'SI' => __( 'Slovenia', 'tasheel' ), 'SO' => __( 'Somalia', 'tasheel' ), 'ZA' => __( 'South Africa', 'tasheel' ), 'KR' => __( 'South Korea', 'tasheel' ),
				'SS' => __( 'South Sudan', 'tasheel' ), 'ES' => __( 'Spain', 'tasheel' ), 'LK' => __( 'Sri Lanka', 'tasheel' ), 'SD' => __( 'Sudan', 'tasheel' ), 'SR' => __( 'Suriname', 'tasheel' ),
				'SE' => __( 'Sweden', 'tasheel' ), 'CH' => __( 'Switzerland', 'tasheel' ), 'SY' => __( 'Syria', 'tasheel' ), 'TW' => __( 'Taiwan', 'tasheel' ), 'TJ' => __( 'Tajikistan', 'tasheel' ),
				'TZ' => __( 'Tanzania', 'tasheel' ), 'TH' => __( 'Thailand', 'tasheel' ), 'TL' => __( 'Timor-Leste', 'tasheel' ), 'TG' => __( 'Togo', 'tasheel' ), 'TO' => __( 'Tonga', 'tasheel' ),
				'TT' => __( 'Trinidad & Tobago', 'tasheel' ), 'TN' => __( 'Tunisia', 'tasheel' ), 'TR' => __( 'Turkey', 'tasheel' ), 'TM' => __( 'Turkmenistan', 'tasheel' ),
				'UG' => __( 'Uganda', 'tasheel' ), 'UA' => __( 'Ukraine', 'tasheel' ), 'AE' => __( 'United Arab Emirates', 'tasheel' ), 'GB' => __( 'United Kingdom', 'tasheel' ),
				'US' => __( 'United States', 'tasheel' ), 'UY' => __( 'Uruguay', 'tasheel' ), 'UZ' => __( 'Uzbekistan', 'tasheel' ), 'VE' => __( 'Venezuela', 'tasheel' ),
				'VN' => __( 'Vietnam', 'tasheel' ), 'YE' => __( 'Yemen', 'tasheel' ), 'ZM' => __( 'Zambia', 'tasheel' ), 'ZW' => __( 'Zimbabwe', 'tasheel' ),
			);
			asort( $by_lang[ $lang ] );
		}
	}
	return $by_lang[ $lang ];
}

/**
 * Get list of nationalities (same as countries for dropdown - country name = nationality).
 *
 * @return array<string, string>
 */
function tasheel_hr_get_nationalities() {
	return tasheel_hr_get_countries();
}

/**
 * Get country/nationality display name from ISO code.
 *
 * @param string $code ISO 3166-1 alpha-2 code (e.g. SA, US) or legacy (saudi, usa, uk).
 * @return string Country name or code if not found.
 */
function tasheel_hr_get_country_name( $code ) {
	if ( empty( $code ) ) {
		return '';
	}
	$code_lower = strtolower( $code );
	$is_ar     = ( tasheel_hr_get_country_list_language() === 'ar' );
	$legacy_en = array( 'saudi' => 'Saudi Arabia', 'usa' => 'United States', 'uk' => 'United Kingdom', 'other' => 'Other' );
	$legacy_ar = array( 'saudi' => 'المملكة العربية السعودية', 'usa' => 'الولايات المتحدة', 'uk' => 'المملكة المتحدة', 'other' => 'أخرى' );
	$legacy    = $is_ar ? $legacy_ar : $legacy_en;
	if ( isset( $legacy[ $code_lower ] ) ) {
		return $legacy[ $code_lower ];
	}
	$countries = tasheel_hr_get_countries();
	return isset( $countries[ $code ] ) ? $countries[ $code ] : $code;
}

/**
 * User meta keys for applicant profile (all stored in wp_usermeta).
 */
function tasheel_hr_profile_meta_keys() {
	return array(
		// Contact
		'profile_photo'           => 'profile_photo',
		'profile_title'           => 'profile_title',
		'profile_first_name'      => 'profile_first_name',
		'profile_middle_name'     => 'profile_middle_name',
		'profile_last_name'       => 'profile_last_name',
		'profile_phone'           => 'profile_phone',
		// Diversity
		'profile_gender'          => 'profile_gender',
		'profile_marital_status'  => 'profile_marital_status',
		'profile_dob'             => 'profile_dob',
		'profile_national_status' => 'profile_national_status',
		'profile_nationality'     => 'profile_nationality',
		'profile_location'        => 'profile_location',
		// Address
		'profile_country'         => 'profile_country',
		'profile_city'            => 'profile_city',
		'profile_address_1'       => 'profile_address_1',
		'profile_address_2'       => 'profile_address_2',
		'profile_po_box'          => 'profile_po_box',
		'profile_postal_code'     => 'profile_postal_code',
		// Documents
		'profile_resume'          => 'profile_resume',
		'profile_linkedin'        => 'profile_linkedin',
		// Education (JSON array)
		'profile_education'       => 'profile_education',
		// Experience (JSON array)
		'profile_experience'      => 'profile_experience',
		'profile_has_experience'  => 'profile_has_experience',
		// Licenses (JSON array)
		'profile_licenses'        => 'profile_licenses',
		// Saudi Council (document URL and optional thumbnail for PDF)
		'profile_saudi_council'     => 'profile_saudi_council',
		'profile_saudi_council_thumb' => 'profile_saudi_council_thumb',
		// Additional
		'profile_years_experience'=> 'profile_years_experience',
		'profile_specialization'   => 'profile_specialization',
		'profile_notice_period'   => 'profile_notice_period',
		'profile_current_salary'  => 'profile_current_salary',
		'profile_expected_salary' => 'profile_expected_salary',
		'profile_visa_status'     => 'profile_visa_status',
		// Documents
		'profile_portfolio'       => 'profile_portfolio',
		// Employment at Saud Consult
		'profile_currently_employed'   => 'profile_currently_employed',
		'profile_employee_id'          => 'profile_employee_id',
		'profile_current_project'      => 'profile_current_project',
		'profile_current_department'   => 'profile_current_department',
		'profile_previously_worked'    => 'profile_previously_worked',
		'profile_previous_duration'    => 'profile_previous_duration',
		'profile_last_project'         => 'profile_last_project',
		'profile_previous_department'  => 'profile_previous_department',
		// Recent projects (JSON array)
		'profile_recent_projects' => 'profile_recent_projects',
	);
}

/**
 * Human-readable labels for profile meta keys (for backend display).
 *
 * @return array Meta key => label.
 */
function tasheel_hr_profile_meta_labels() {
	return array(
		'profile_photo'           => __( 'Photo', 'tasheel' ),
		'profile_title'           => __( 'Title', 'tasheel' ),
		'profile_first_name'      => __( 'First Name', 'tasheel' ),
		'profile_middle_name'     => __( 'Middle Name', 'tasheel' ),
		'profile_last_name'       => __( 'Last Name', 'tasheel' ),
		'profile_phone'           => __( 'Phone', 'tasheel' ),
		'profile_gender'          => __( 'Gender', 'tasheel' ),
		'profile_marital_status'  => __( 'Marital Status', 'tasheel' ),
		'profile_dob'             => __( 'Date of Birth', 'tasheel' ),
		'profile_national_status' => __( 'National Status', 'tasheel' ),
		'profile_nationality'     => __( 'Nationality', 'tasheel' ),
		'profile_location'        => __( 'Location', 'tasheel' ),
		'profile_country'         => __( 'Country', 'tasheel' ),
		'profile_city'            => __( 'City', 'tasheel' ),
		'profile_address_1'       => __( 'Address Line 1', 'tasheel' ),
		'profile_address_2'       => __( 'Address Line 2', 'tasheel' ),
		'profile_po_box'          => __( 'PO Box', 'tasheel' ),
		'profile_postal_code'     => __( 'Postal Code', 'tasheel' ),
		'profile_resume'          => __( 'Resume', 'tasheel' ),
		'profile_linkedin'        => __( 'LinkedIn', 'tasheel' ),
		'profile_education'       => __( 'Education', 'tasheel' ),
		'profile_experience'      => __( 'Experience', 'tasheel' ),
		'profile_licenses'        => __( 'Licenses', 'tasheel' ),
		'profile_saudi_council'   => __( 'Saudi Council', 'tasheel' ),
		'profile_years_experience'=> __( 'Years of Experience', 'tasheel' ),
		'profile_specialization'   => __( 'Specialization', 'tasheel' ),
		'profile_notice_period'   => __( 'Notice Period', 'tasheel' ),
		'profile_current_salary'  => __( 'Current Salary', 'tasheel' ),
		'profile_expected_salary' => __( 'Expected Salary', 'tasheel' ),
		'profile_visa_status'     => __( 'Visa Status', 'tasheel' ),

		'profile_portfolio'       => __( 'Portfolio', 'tasheel' ),
		'profile_currently_employed'   => __( 'Currently employed at Saud Consult?', 'tasheel' ),
		'profile_employee_id'          => __( 'Employee ID', 'tasheel' ),
		'profile_current_project'      => __( 'Current Project', 'tasheel' ),
		'profile_current_department'   => __( 'Current Department', 'tasheel' ),
		'profile_previously_worked'    => __( 'Previously worked at Saud Consult?', 'tasheel' ),
		'profile_previous_duration'    => __( 'Duration', 'tasheel' ),
		'profile_last_project'         => __( 'Last Project', 'tasheel' ),
		'profile_previous_department'  => __( 'Previous Department', 'tasheel' ),
		'profile_recent_projects' => __( 'Recent Projects', 'tasheel' ),
	);
}

/**
 * Snapshot keys for applicant export, in the same order as the Create Profile form.
 * Used by Job Applications export (CSV/Excel) so column order matches the form.
 * Excludes keys that are in main export columns: profile_title, profile_first_name, profile_middle_name, profile_last_name, profile_email, profile_resume.
 *
 * @return string[] Ordered list of snapshot meta keys.
 */
function tasheel_hr_export_snapshot_keys_in_form_order() {
	return array(
		// Contact: Photo first so export shows Resume URL then Photo (documents together), then Phone
		'profile_photo',
		'profile_phone',
		// Diversity Information
		'profile_gender',
		'profile_marital_status',
		'profile_dob',
		'profile_national_status',
		'profile_nationality',
		'profile_location',
		// Supporting Documents and URLs (resume excluded)
		'profile_linkedin',
		'profile_portfolio',
		// Education, Experience, Licenses
		'profile_education',
		'profile_experience',
		'profile_licenses',
		// Saudi Council
		'profile_saudi_council',
		// Additional Information
		'profile_years_experience',
		'profile_specialization',
		'profile_notice_period',
		'profile_current_salary',
		'profile_expected_salary',
		'profile_visa_status',
		// Employment History at Saud Consult
		'profile_currently_employed',
		'profile_employee_id',
		'profile_current_project',
		'profile_current_department',
		'profile_previously_worked',
		'profile_previous_duration',
		'profile_last_project',
		'profile_previous_department',
		// Recent Projects
		'profile_recent_projects',
		// Training (application meta; not in form but in application)
		'start_date',
		'duration',
	);
}

/**
 * Title (salutation) dropdown options for Create Profile and Apply as Guest.
 * Value => label; use empty string as first option for "Title *" placeholder.
 *
 * @return array Value => translated label.
 */
function tasheel_hr_title_salutation_options() {
	return array(
		''    => __( 'Title *', 'tasheel' ),
		'mr'  => __( 'Mr.', 'tasheel' ),
		'ms'  => __( 'Ms.', 'tasheel' ),
		'mrs' => __( 'Mrs.', 'tasheel' ),
		'miss' => __( 'Miss', 'tasheel' ),
		'dr'  => __( 'Dr.', 'tasheel' ),
		'prof' => __( 'Prof.', 'tasheel' ),
	);
}

/**
 * Visa status options for forms and filters (value => label).
 * Used in create-profile, admin application filter, and anywhere visa status is displayed.
 *
 * @return array Value => human-readable label.
 */
function tasheel_hr_visa_status_options() {
	return array(
		'has_visa' => __( 'Has Visa / Residency', 'tasheel' ),
		'no_visa'  => __( 'No Visa', 'tasheel' ),
	);
}

/**
 * Get human-readable label for a visa status value.
 * Supports current values (has_visa, no_visa) and legacy (box1, box2) for backward compatibility.
 *
 * @param string $value Stored value (e.g. has_visa, no_visa, box1, box2).
 * @return string Label or original value if unknown.
 */
function tasheel_hr_visa_status_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '—';
	}
	$options = tasheel_hr_visa_status_options();
	if ( isset( $options[ $value ] ) ) {
		return $options[ $value ];
	}
	$legacy = array(
		'box1' => __( 'Has Visa / Residency', 'tasheel' ),
		'box2' => __( 'No Visa', 'tasheel' ),
	);
	return isset( $legacy[ $value ] ) ? $legacy[ $value ] : $value;
}

/**
 * Display label for title (salutation) on Review Profile and elsewhere.
 * Dropdown value is stored as-is; this returns the correct capitalised static label.
 *
 * @param string $value Stored value (e.g. mr, ms, dr).
 * @return string Label (e.g. Mr., Ms., Dr.) or original value if unknown.
 */
function tasheel_hr_title_display_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '—';
	}
	$opts = tasheel_hr_title_salutation_options();
	return isset( $opts[ $value ] ) ? $opts[ $value ] : $value;
}

/**
 * Display label for gender on Review Profile. Static dropdown values → capitalised label.
 *
 * @param string $value Stored value (e.g. male, female).
 * @return string Label (e.g. Male, Female) or original value if unknown.
 */
function tasheel_hr_gender_display_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '—';
	}
	$labels = array(
		'male'             => __( 'Male', 'tasheel' ),
		'female'           => __( 'Female', 'tasheel' ),
		'other'            => __( 'Other', 'tasheel' ),
		'prefer-not-to-say' => __( 'Prefer not to say', 'tasheel' ),
	);
	return isset( $labels[ $value ] ) ? $labels[ $value ] : ucfirst( $value );
}

/**
 * Display label for marital status on Review Profile. Static dropdown values → capitalised label.
 *
 * @param string $value Stored value (e.g. single, married).
 * @return string Label (e.g. Single, Married) or original value if unknown.
 */
function tasheel_hr_marital_status_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '—';
	}
	$labels = array(
		'single'  => __( 'Single', 'tasheel' ),
		'married' => __( 'Married', 'tasheel' ),
	);
	return isset( $labels[ $value ] ) ? $labels[ $value ] : ucfirst( $value );
}

/**
 * Display label for department on Review Profile. Static dropdown values → capitalised label.
 *
 * @param string $value Stored value (e.g. engineering, design, management).
 * @return string Label (e.g. Engineering, Design, Management) or original value if unknown.
 */
function tasheel_hr_department_display_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '—';
	}
	$labels = array(
		'engineering' => __( 'Engineering', 'tasheel' ),
		'design'       => __( 'Design', 'tasheel' ),
		'management'  => __( 'Management', 'tasheel' ),
	);
	return isset( $labels[ $value ] ) ? $labels[ $value ] : ucfirst( $value );
}

/**
 * Display label for education degree. Static dropdown values → correct label.
 *
 * @param string $value Stored value (e.g. bachelor, master, phd).
 * @return string Label (e.g. Bachelor's Degree, Master's Degree) or original value if unknown.
 */
function tasheel_hr_education_degree_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '';
	}
	$labels = array(
		'bachelor' => __( "Bachelor's Degree", 'tasheel' ),
		'master'   => __( "Master's Degree", 'tasheel' ),
		'phd'      => __( 'PhD', 'tasheel' ),
		'diploma'  => __( 'Diploma', 'tasheel' ),
	);
	return isset( $labels[ $value ] ) ? $labels[ $value ] : ucfirst( $value );
}

/**
 * Display label for education major. Static dropdown values → correct label.
 *
 * @param string $value Stored value (e.g. engineering, business, science).
 * @return string Label (e.g. Engineering, Business, Science) or original value if unknown.
 */
function tasheel_hr_education_major_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '';
	}
	$labels = array(
		'engineering' => __( 'Engineering', 'tasheel' ),
		'business'    => __( 'Business', 'tasheel' ),
		'science'     => __( 'Science', 'tasheel' ),
	);
	return isset( $labels[ $value ] ) ? $labels[ $value ] : ucfirst( $value );
}

/**
 * Display label for education mode. Static dropdown values → correct label.
 *
 * @param string $value Stored value (e.g. full-time, part-time, online).
 * @return string Label (e.g. Full-time, Part-time, Online) or original value if unknown.
 */
function tasheel_hr_education_mode_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '';
	}
	$labels = array(
		'full-time' => __( 'Full-time', 'tasheel' ),
		'part-time' => __( 'Part-time', 'tasheel' ),
		'online'     => __( 'Online', 'tasheel' ),
	);
	return isset( $labels[ $value ] ) ? $labels[ $value ] : ucfirst( $value );
}

/**
 * Display label for recent-project position. Static dropdown values → correct label.
 *
 * @param string $value Stored value (e.g. engineer, senior-engineer, manager).
 * @return string Label (e.g. Engineer, Senior Engineer, Manager) or original value if unknown.
 */
function tasheel_hr_project_position_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '';
	}
	$labels = array(
		'engineer'        => __( 'Engineer', 'tasheel' ),
		'senior-engineer' => __( 'Senior Engineer', 'tasheel' ),
		'manager'         => __( 'Manager', 'tasheel' ),
	);
	return isset( $labels[ $value ] ) ? $labels[ $value ] : $value;
}

/**
 * Display label for recent-project period. Static dropdown values → correct label.
 *
 * @param string $value Stored value (e.g. 0-1, 1-3, 3-5, 5+).
 * @return string Label (e.g. 0-1 years, 1-3 years) or original value if unknown.
 */
function tasheel_hr_project_period_label( $value ) {
	if ( ! is_string( $value ) || $value === '' ) {
		return '';
	}
	$labels = array(
		'0-1' => __( '0-1 years', 'tasheel' ),
		'1-3' => __( '1-3 years', 'tasheel' ),
		'3-5' => __( '3-5 years', 'tasheel' ),
		'5+'  => __( '5+ years', 'tasheel' ),
	);
	return isset( $labels[ $value ] ) ? $labels[ $value ] : $value;
}

/**
 * Labels for education/experience sub-fields (for granular validation errors).
 * Keys are suffix after profile_education_N_ or profile_experience_N_
 *
 * @return array
 */
function tasheel_hr_profile_subfield_labels() {
	return array(
		'degree'      => __( 'Degree', 'tasheel' ),
		'institute'   => __( 'Institute', 'tasheel' ),
		'major'       => __( 'Major', 'tasheel' ),
		'start_date'  => __( 'Start Date', 'tasheel' ),
		'end_date'    => __( 'End Date', 'tasheel' ),
		'city'        => __( 'City', 'tasheel' ),
		'country'     => __( 'Country', 'tasheel' ),
		'gpa'         => __( 'GPA', 'tasheel' ),
		'avg_grade'   => __( 'Average Grade', 'tasheel' ),
		'mode'        => __( 'Mode of study', 'tasheel' ),
		'employer'    => __( 'Employer Name', 'tasheel' ),
		'job_title'   => __( 'Job Title', 'tasheel' ),
		'years'       => __( 'Years of Experience', 'tasheel' ),
		'salary'      => __( 'Salary', 'tasheel' ),
		'benefits'    => __( 'Benefits', 'tasheel' ),
		'company'     => __( 'Company Name', 'tasheel' ),
		'client'      => __( 'Client Name', 'tasheel' ),
		'period'      => __( 'Period', 'tasheel' ),
		'position'    => __( 'Position', 'tasheel' ),
		'duties'      => __( 'Duties & Responsibilities', 'tasheel' ),
	);
}

/**
 * Get human-readable label for a granular field error key (e.g. profile_experience_0_country).
 * Returns plain subfield label for all blocks (no "Education 2", "Experience 2" prefix).
 *
 * @param string $key Key like profile_experience_0_country or profile_title.
 * @return string
 */
function tasheel_hr_profile_field_error_label( $key ) {
	$labels = function_exists( 'tasheel_hr_profile_meta_labels' ) ? tasheel_hr_profile_meta_labels() : array();
	if ( isset( $labels[ $key ] ) ) {
		return $labels[ $key ];
	}
	$sub = function_exists( 'tasheel_hr_profile_subfield_labels' ) ? tasheel_hr_profile_subfield_labels() : array();
	if ( preg_match( '/^profile_experience_(\d+)_(.+)$/', $key, $m ) && isset( $sub[ $m[2] ] ) ) {
		return $sub[ $m[2] ];
	}
	if ( preg_match( '/^profile_education_(\d+)_(.+)$/', $key, $m ) && isset( $sub[ $m[2] ] ) ) {
		return $sub[ $m[2] ];
	}
	if ( preg_match( '/^profile_recent_projects_(\d+)_(.+)$/', $key, $m ) && isset( $sub[ $m[2] ] ) ) {
		return $sub[ $m[2] ];
	}
	return $key;
}

/**
 * Minimum number of digits required for a valid phone number. Used for Create Profile and Guest apply.
 *
 * @return int
 */
function tasheel_hr_profile_phone_min_digits() {
	return (int) apply_filters( 'tasheel_hr_profile_phone_min_digits', 8 );
}

/**
 * Count digits in a phone string (strips spaces, dashes, plus, parentheses).
 *
 * @param string $value Phone value.
 * @return int
 */
function tasheel_hr_profile_phone_digit_count( $value ) {
	if ( ! is_string( $value ) ) {
		return 0;
	}
	$digits = preg_replace( '/[^0-9]/', '', $value );
	return $digits !== '' ? strlen( $digits ) : 0;
}

/**
 * Whether the phone value is valid: non-empty and at least minimum digits.
 * Shared by Create Profile and Guest apply for consistent validation.
 *
 * @param string $value Phone value.
 * @return bool
 */
function tasheel_hr_profile_phone_is_valid( $value ) {
	$s = is_string( $value ) ? trim( $value ) : '';
	if ( $s === '' ) {
		return false;
	}
	return tasheel_hr_profile_phone_digit_count( $s ) >= tasheel_hr_profile_phone_min_digits();
}

/**
 * Validate profile photo upload: only JPG/PNG, max 1MB. Returns error message or empty string.
 *
 * @return string Error message if invalid, empty string if valid or no file.
 */
function tasheel_hr_validate_profile_photo_upload() {
	if ( empty( $_FILES['profile_photo']['name'] ) || empty( $_FILES['profile_photo']['tmp_name'] ) ) {
		return '';
	}
	$name = sanitize_file_name( wp_unslash( $_FILES['profile_photo']['name'] ) );
	$ext  = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );
	$allowed = array( 'jpg', 'jpeg', 'png' );
	if ( ! in_array( $ext, $allowed, true ) ) {
		return __( 'Only PNG, JPG and JPEG images are allowed. Max 1MB.', 'tasheel' );
	}
	$size = isset( $_FILES['profile_photo']['size'] ) ? (int) $_FILES['profile_photo']['size'] : 0;
	$max  = 1024 * 1024; // 1MB
	if ( $size > $max ) {
		return __( 'Profile photo must be 1MB or less.', 'tasheel' );
	}
	return '';
}

/**
 * Validate a document file upload (resume, portfolio, saudi council): type and max size.
 * Used for Create Profile and Apply as Guest.
 *
 * @param string $file_key   Key in $_FILES (e.g. 'profile_resume', 'profile_portfolio', 'saudi_council_certificate').
 * @param array  $allowed_exts Allowed extensions (e.g. array( 'pdf', 'doc', 'docx' )).
 * @param int    $max_mb     Max size in MB (default 5).
 * @return string Error message if invalid, empty string if valid or no file.
 */
function tasheel_hr_validate_profile_document_upload( $file_key, $allowed_exts, $max_mb = 5 ) {
	if ( empty( $_FILES[ $file_key ]['name'] ) || empty( $_FILES[ $file_key ]['tmp_name'] ) ) {
		return '';
	}
	$file = isset( $_FILES[ $file_key ] ) && is_array( $_FILES[ $file_key ] ) ? $_FILES[ $file_key ] : null;
	if ( ! $file || ! is_string( $file['name'] ?? '' ) ) {
		return __( 'Invalid file. Allowed types and max size are shown below the field.', 'tasheel' );
	}
	$ext = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
	if ( ! in_array( $ext, $allowed_exts, true ) ) {
		return __( 'Please upload a file with allowed type (see below). Max ' . $max_mb . 'MB.', 'tasheel' );
	}
	$max_bytes = $max_mb * 1024 * 1024;
	$size      = isset( $file['size'] ) ? (int) $file['size'] : 0;
	if ( $size > $max_bytes ) {
		return __( 'File is too large. Please upload a file up to ' . $max_mb . 'MB.', 'tasheel' );
	}
	return '';
}

/**
 * Validate profile file uploads (resume, portfolio, saudi council) for current request.
 * Photo is validated separately by tasheel_hr_validate_profile_photo_upload().
 *
 * @return array Associative array meta_key => error message (only invalid fields).
 */
function tasheel_hr_validate_profile_file_uploads() {
	$errors = array();
	$checks = array(
		'profile_resume'        => array( 'file_key' => 'profile_resume', 'exts' => array( 'pdf', 'doc', 'docx' ) ),
		'profile_portfolio'     => array( 'file_key' => 'profile_portfolio', 'exts' => array( 'pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png' ) ),
		'profile_saudi_council' => array( 'file_key' => 'saudi_council_certificate', 'exts' => array( 'pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png' ) ),
	);
	foreach ( $checks as $meta_key => $config ) {
		$err = tasheel_hr_validate_profile_document_upload( $config['file_key'], $config['exts'], 5 );
		if ( $err !== '' ) {
			$errors[ $meta_key ] = $err;
		}
	}
	return $errors;
}

/** Static storage for file validation errors set during tasheel_hr_build_profile_data_from_request (invalid file = skip upload). */
$tasheel_hr_profile_file_validation_errors = array();

/**
 * Set profile file validation errors (used when build skips an invalid upload).
 *
 * @param array $errors meta_key => message.
 */
function tasheel_hr_set_profile_file_validation_errors( $errors ) {
	global $tasheel_hr_profile_file_validation_errors;
	$tasheel_hr_profile_file_validation_errors = is_array( $errors ) ? $errors : array();
}

/**
 * Append one profile file validation error.
 *
 * @param string $meta_key Meta key (e.g. profile_resume).
 * @param string $message  Error message.
 */
function tasheel_hr_append_profile_file_validation_error( $meta_key, $message ) {
	global $tasheel_hr_profile_file_validation_errors;
	$tasheel_hr_profile_file_validation_errors[ $meta_key ] = $message;
}

/**
 * Get profile file validation errors set during last build.
 *
 * @return array meta_key => message.
 */
function tasheel_hr_get_profile_file_validation_errors() {
	global $tasheel_hr_profile_file_validation_errors;
	return is_array( $tasheel_hr_profile_file_validation_errors ) ? $tasheel_hr_profile_file_validation_errors : array();
}

/**
 * Format validation for profile fields (letters only, phone length, numbers, etc.).
 * Same rules as vendor form where applicable. Used for Create Profile and Apply as Guest.
 *
 * @param array $profile Profile data (merged current + submitted).
 * @return array Associative array field_key => error message (only invalid fields).
 */
function tasheel_hr_profile_format_validation( $profile ) {
	$errors = array();
	$get = function( $key ) use ( $profile ) {
		return isset( $profile[ $key ] ) ? trim( (string) $profile[ $key ] ) : '';
	};

	// First name, last name: letters, spaces, hyphens only.
	foreach ( array( 'profile_first_name', 'profile_last_name' ) as $key ) {
		$v = $get( $key );
		if ( $v !== '' && ! preg_match( '/^[a-zA-Z\s\-]{2,50}$/', $v ) ) {
			$errors[ $key ] = __( 'Please enter letters only (no numbers or special characters).', 'tasheel' );
		}
	}

	// Phone: 7–15 digits (with optional +, spaces, hyphens, parentheses).
	if ( $get( 'profile_phone' ) !== '' ) {
		if ( ! preg_match( '/^\+?[0-9\s\-\(\)]{7,15}$/', $get( 'profile_phone' ) ) ) {
			$errors[ 'profile_phone' ] = __( 'Please enter a valid phone number (7–15 digits).', 'tasheel' );
		} elseif ( function_exists( 'tasheel_hr_profile_phone_is_valid' ) && ! tasheel_hr_profile_phone_is_valid( $get( 'profile_phone' ) ) ) {
			$min = function_exists( 'tasheel_hr_profile_phone_min_digits' ) ? tasheel_hr_profile_phone_min_digits() : 8;
			$errors[ 'profile_phone' ] = sprintf( __( 'Please enter a valid phone number (at least %d digits).', 'tasheel' ), $min );
		}
	}

	// Years of experience: numeric if present.
	$y = $get( 'profile_years_experience' );
	if ( $y !== '' && ! preg_match( '/^[0-9]+$/', $y ) ) {
		$errors[ 'profile_years_experience' ] = __( 'Please enter a valid number (digits only).', 'tasheel' );
	}

	// Current/expected salary: accept dropdown values as-is (e.g. "0-5000", "5000-10000", "15000+").
	foreach ( array( 'profile_current_salary', 'profile_expected_salary' ) as $key ) {
		$v = $get( $key );
		if ( $v === '' ) {
			continue;
		}
		// Allow digits, hyphens (for ranges), and optional trailing + (e.g. 15000+).
		if ( ! preg_match( '/^[0-9][0-9\-]*\+?$/', $v ) ) {
			$errors[ $key ] = __( 'Please select a valid option.', 'tasheel' );
		}
	}

	// LinkedIn: valid URL only (must be proper URL format with scheme).
	$linkedin = $get( 'profile_linkedin' );
	if ( $linkedin !== '' ) {
		$linkedin_trimmed = trim( $linkedin );
		if ( $linkedin_trimmed === '' || filter_var( $linkedin_trimmed, FILTER_VALIDATE_URL ) === false ) {
			$errors[ 'profile_linkedin' ] = __( 'Please enter a valid URL.', 'tasheel' );
		}
	}

	// Location: address-style (letters, numbers, spaces, common punctuation).
	$loc = $get( 'profile_location' );
	if ( $loc !== '' && ! preg_match( '/^[a-zA-Z0-9\s\-\.&,\/]{2,150}$/', $loc ) ) {
		$errors[ 'profile_location' ] = __( 'Please enter a valid address or location (letters, numbers and common punctuation only).', 'tasheel' );
	}

	// Specialization (if free text): letters, numbers, spaces, hyphens.
	$spec = $get( 'profile_specialization' );
	if ( $spec !== '' && ! preg_match( '/^[a-zA-Z0-9\s\-\.&,()]{2,200}$/', $spec ) ) {
		$errors[ 'profile_specialization' ] = __( 'Please enter a valid value (no invalid characters).', 'tasheel' );
	}

	// Notice period: letters or numbers (e.g. "2 weeks", "1 month").
	$notice = $get( 'profile_notice_period' );
	if ( $notice !== '' && ! preg_match( '/^[a-zA-Z0-9\s\-\.]{1,50}$/', $notice ) ) {
		$errors[ 'profile_notice_period' ] = __( 'Please enter a valid value.', 'tasheel' );
	}

	return $errors;
}

/**
 * Get the validation error message for a profile field. Same message for Create Profile and Guest apply.
 * For profile_phone: "Phone is required." or "Phone must be at least X digits."; others: label + required_msg.
 *
 * @param string $key          Field key (e.g. profile_phone, profile_first_name).
 * @param string $value        Current value (used for profile_phone to choose required vs min length message).
 * @param string $required_msg  Default "is required." (translated).
 * @return string
 */
function tasheel_hr_get_field_error_message( $key, $value, $required_msg ) {
	$label = function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( $key ) : $key;
	if ( $key === 'profile_phone' ) {
		$trimmed = is_string( $value ) ? trim( $value ) : '';
		if ( $trimmed === '' ) {
			return $label . ' ' . $required_msg;
		}
		if ( ! function_exists( 'tasheel_hr_profile_phone_is_valid' ) || ! tasheel_hr_profile_phone_is_valid( $value ) ) {
			$min = function_exists( 'tasheel_hr_profile_phone_min_digits' ) ? tasheel_hr_profile_phone_min_digits() : 8;
			return $label . ' ' . sprintf(
				/* translators: %d: minimum number of digits */
				__( 'must be at least %d digits.', 'tasheel' ),
				$min
			);
		}
	}
	return $label . ' ' . $required_msg;
}

/**
 * All profile field keys that can show a required error, including education/experience/recent projects blocks.
 * Used to build a client-side message map so validation messages match backend and Apply as Guest.
 *
 * @param int $max_blocks Max block index for education, experience, recent projects (0 to max_blocks-1).
 * @return array List of field keys.
 */
function tasheel_hr_all_required_field_error_keys( $max_blocks = 10 ) {
	$simple = array(
		'profile_title', 'profile_first_name', 'profile_last_name', 'profile_phone', 'profile_gender',
		'profile_marital_status', 'profile_dob', 'profile_national_status', 'profile_nationality', 'profile_location',
		'profile_photo', 'profile_resume', 'profile_saudi_council', 'profile_education', 'profile_experience',
		'profile_years_experience', 'profile_specialization', 'profile_notice_period', 'profile_current_salary',
		'profile_expected_salary', 'profile_visa_status', 'profile_employee_id', 'profile_current_project',
		'profile_current_department', 'profile_previous_duration', 'profile_last_project', 'profile_previous_department',
		'profile_recent_projects',
	);
	$edu_sub   = array( 'degree', 'institute', 'major', 'start_date', 'end_date', 'city', 'country', 'gpa', 'avg_grade', 'mode' );
	$exp_sub   = array( 'employer', 'job_title', 'start_date', 'end_date', 'country', 'years', 'salary', 'benefits' );
	$proj_sub  = array( 'company', 'client', 'period', 'position', 'duties' );
	$keys = $simple;
	for ( $n = 0; $n < $max_blocks; $n++ ) {
		foreach ( $edu_sub as $f ) {
			$keys[] = 'profile_education_' . $n . '_' . $f;
		}
		foreach ( $exp_sub as $f ) {
			$keys[] = 'profile_experience_' . $n . '_' . $f;
		}
		foreach ( $proj_sub as $f ) {
			$keys[] = 'profile_recent_projects_' . $n . '_' . $f;
		}
	}
	return $keys;
}

/**
 * Build key => message map for all required fields. Same messages as backend and Apply as Guest.
 *
 * @param string $required_msg Translated "is required." (e.g. __( 'is required.', 'tasheel' )).
 * @param int    $max_blocks    Max block index for repeatable sections (default 10).
 * @return array Associative array key => message.
 */
function tasheel_hr_get_all_required_field_messages( $required_msg, $max_blocks = 10 ) {
	$keys   = function_exists( 'tasheel_hr_all_required_field_error_keys' ) ? tasheel_hr_all_required_field_error_keys( $max_blocks ) : array();
	$result = array();
	foreach ( $keys as $key ) {
		$result[ $key ] = function_exists( 'tasheel_hr_get_field_error_message' )
			? tasheel_hr_get_field_error_message( $key, '', $required_msg )
			: ( ( function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( $key ) : $key ) . ' ' . $required_msg );
	}
	return $result;
}

/**
 * Sanitize a scalar profile value for storage. Strips HTML/scripts and validates format where applicable.
 * Use for all text/url/textarea inputs to prevent XSS and injection.
 *
 * @param string $key   Profile meta key (e.g. profile_linkedin, profile_phone).
 * @param string $value Raw input value.
 * @return string Sanitized value, or empty string if invalid/dangerous.
 */
function tasheel_hr_sanitize_profile_scalar( $key, $value ) {
	if ( ! is_string( $value ) ) {
		return '';
	}
	$value = trim( $value );
	// Strip all HTML and normalize whitespace.
	$value = sanitize_text_field( $value );
	// Reject values that contain script-like or event-handler patterns (defence in depth).
	$dangerous = array( '<script', '</script', 'javascript:', 'vbscript:', 'data:text/html', 'onerror=', 'onload=', 'onclick=', 'onfocus=', 'onblur=', 'oninput=' );
	$lower = strtolower( $value );
	foreach ( $dangerous as $pat ) {
		if ( strpos( $lower, $pat ) !== false ) {
			return '';
		}
	}
	// URL field: allow only valid URL; allow empty (optional).
	if ( 'profile_linkedin' === $key && $value !== '' ) {
		$value = trim( (string) $value );
		if ( $value === '' || filter_var( $value, FILTER_VALIDATE_URL ) === false ) {
			return '';
		}
	}
	return $value;
}

/**
 * Sanitize textarea content (multiline). Strips HTML/scripts.
 *
 * @param string $value Raw input.
 * @return string Sanitized value.
 */
function tasheel_hr_sanitize_profile_textarea( $value ) {
	if ( ! is_string( $value ) ) {
		return '';
	}
	$value = sanitize_textarea_field( $value );
	$dangerous = array( '<script', '</script', 'javascript:', 'vbscript:', 'data:text/html', 'onerror=', 'onload=', 'onclick=' );
	$lower = strtolower( $value );
	foreach ( $dangerous as $pat ) {
		if ( strpos( $lower, $pat ) !== false ) {
			return '';
		}
	}
	return $value;
}

/**
 * Fetch specialization options from a published Google Sheet CSV URL.
 * Default: no cache (0) so sheet updates show immediately. Use filter to add caching if needed.
 *
 * Supported formats (first row can be a header and will be skipped):
 * - 1 column: label only (value = sanitize_title or opt-N).
 * - 2 columns (arbname, engname): Column A = Arabic, Column B = English. Label is chosen by WPML
 *   current language (Arabic when /ar/ or language code 'ar', else English).
 * - 2 columns (other): label, value.
 * - 3 columns: value, english_label, arabic_label — label chosen by WPML current language.
 *
 * @param string $url Public CSV export URL (e.g. from File → Share → Publish to web → CSV).
 * @return array Empty on failure; otherwise array of value => label (slug => name).
 */
function tasheel_hr_fetch_specialization_from_google_sheet( $url ) {
	$url = is_string( $url ) ? trim( $url ) : '';
	if ( $url === '' || ! preg_match( '#^https?://#i', $url ) ) {
		return array();
	}
	// Prefer URL for language: only show Arabic when the request contains /ar/ (e.g. /ar/create-profile/).
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? (string) $_SERVER['REQUEST_URI'] : '';
	$lang = ( strpos( $uri, '/ar/' ) !== false || strpos( $uri, '/ar?' ) !== false )
		? 'ar'
		: ( function_exists( 'apply_filters' ) ? apply_filters( 'wpml_current_language', 'en' ) : 'en' );
	$cache_key = 'tasheel_spec_sheet_' . md5( $url ) . '_' . $lang;
	$cache_ttl  = apply_filters( 'tasheel_hr_specialization_sheet_cache_seconds', 0 );
	$cached     = ( $cache_ttl > 0 ) ? get_transient( $cache_key ) : false;
	if ( is_array( $cached ) ) {
		return $cached;
	}
	$request_args = array(
		'timeout'   => 15,
		'sslverify' => apply_filters( 'tasheel_hr_specialization_sheet_sslverify', true ),
		'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . get_bloginfo( 'url' ),
	);
	$response = wp_remote_get( $url, $request_args );
	$code     = wp_remote_retrieve_response_code( $response );
	$body     = wp_remote_retrieve_body( $response );
	if ( is_wp_error( $response ) || $code !== 200 ) {
		if ( $cache_ttl > 0 ) {
			set_transient( $cache_key, array(), 300 );
		}
		return array();
	}
	// Strip UTF-8 BOM if present (Google Sheets may add it). Sheet should be UTF-8 for Arabic etc.
	$body = preg_replace( '/^\xEF\xBB\xBF/', '', $body );
	$lines = preg_split( '/\r\n|\r|\n/', $body );
	$opts  = array();
	$first = true;
	$row_index = 0;
	$is_arb_eng = false; // Set true when first row has headers arbname, engname.
	// Column index for label when using 3-column format (value, en, ar).
	$label_col = ( $lang === 'ar' ) ? 2 : 1;
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( $line === '' ) {
			continue;
		}
		$cells = str_getcsv( $line );
		$cell0 = isset( $cells[0] ) ? trim( (string) $cells[0] ) : '';
		$cell1 = isset( $cells[1] ) ? trim( (string) $cells[1] ) : '';
		if ( $cell0 === '' && $cell1 === '' ) {
			continue;
		}
		$num_cols = count( $cells );

		// 2-column arbname, engname: A = Arabic, B = English. Show Arabic only when URL has /ar/.
		if ( $num_cols >= 2 ) {
			// Always skip header row (arbname, engname) in either column order — never add as option.
			$is_header = ( preg_match( '/^arbname$/i', $cell0 ) && preg_match( '/^engname$/i', $cell1 ) )
				|| ( preg_match( '/^engname$/i', $cell0 ) && preg_match( '/^arbname$/i', $cell1 ) );
			if ( $is_header ) {
				$is_arb_eng = true;
				$first      = false;
				continue;
			}
			if ( $first && ( preg_match( '/^arbname$/i', $cell0 ) || preg_match( '/^engname$/i', $cell0 ) || preg_match( '/^arbname$/i', $cell1 ) || preg_match( '/^engname$/i', $cell1 ) ) ) {
				$is_arb_eng = true;
				$first      = false;
				continue;
			}
			if ( $is_arb_eng ) {
				$label_ar = $cell0;
				$label_en = $cell1;
				// If engname cell contains both English and Arabic, strip Arabic so English view shows only English.
				if ( $lang !== 'ar' && $label_en !== '' && preg_match( '/[\x{0600}-\x{06FF}]/u', $label_en ) ) {
					$label_en = trim( preg_replace( '/\s+/', ' ', preg_replace( '/\s*[\x{0600}-\x{06FF}]+\s*/u', ' ', $label_en ) ) );
				}
				$name = ( $lang === 'ar' ) ? $label_ar : $label_en;
				if ( $name === '' ) {
					$name = $label_en !== '' ? $label_en : $label_ar;
				}
				$value = sanitize_title( $label_en );
				if ( $value === '' ) {
					$value = sanitize_title( $label_ar );
				}
				if ( $value === '' ) {
					$value = 'opt-' . ( ++$row_index );
				}
				$opts[ $value ] = $name;
				continue;
			}
		}

		// 3-column format: value, english, arabic — skip header row.
		if ( $num_cols >= 3 ) {
			if ( $first && preg_match( '/^(value|slug|english|en|arabic|ar|تخصص|الاسم|إنجليزي|عربي)$/ui', $cell0 ) ) {
				$first = false;
				continue;
			}
			$first = false;
			$value = $cell0;
			$name  = isset( $cells[ $label_col ] ) ? trim( (string) $cells[ $label_col ] ) : trim( (string) $cells[1] );
			if ( $name === '' ) {
				$name = isset( $cells[1] ) ? trim( (string) $cells[1] ) : $cell0;
			}
			if ( $value === '' ) {
				$value = 'opt-' . ( ++$row_index );
			}
			$opts[ $value ] = $name;
			continue;
		}

		// 1- or 2-column format (existing behaviour).
		if ( $first && preg_match( '/^specialization|^name|^label|^option|^engname|^تخصص|^الاسم|^الخيار$/u', $cell0 ) ) {
			$first = false;
			continue;
		}
		$first = false;
		$name  = $cell0;
		$value = $cell1;
		if ( $value === '' ) {
			$value = sanitize_title( $name );
		}
		if ( $value === '' ) {
			$value = 'opt-' . ( ++$row_index );
		}
		$opts[ $value ] = $name;
	}
	if ( $cache_ttl > 0 ) {
		set_transient( $cache_key, $opts, $cache_ttl );
	}
	return $opts;
}

/**
 * Specialization options for select (Additional Information). Filter with tasheel_hr_specialization_options.
 * When a Google Sheet CSV URL is set in Account Options (or via filter), options are loaded from the sheet.
 *
 * @return array Value => label.
 */
function tasheel_hr_specialization_options() {
	$sheet_url = '';
	if ( function_exists( 'get_field' ) ) {
		$sheet_url = get_field( 'specialization_google_sheet_url', 'acf-options-account' );
	}
	if ( ( ! is_string( $sheet_url ) || trim( $sheet_url ) === '' ) && function_exists( 'get_option' ) ) {
		$opts_raw = get_option( 'options_acf-options-account', array() );
		if ( is_array( $opts_raw ) ) {
			$sheet_url = isset( $opts_raw['specialization_google_sheet_url'] ) ? $opts_raw['specialization_google_sheet_url'] : ( isset( $opts_raw['field_account_specialization_sheet_url'] ) ? $opts_raw['field_account_specialization_sheet_url'] : '' );
		}
	}
	if ( ( ! is_string( $sheet_url ) || trim( $sheet_url ) === '' ) && function_exists( 'get_option' ) ) {
		$sheet_url = get_option( 'tasheel_specialization_sheet_url', '' );
	}
	// ACF URL field can return array with 'url' key.
	if ( is_array( $sheet_url ) && isset( $sheet_url['url'] ) ) {
		$sheet_url = $sheet_url['url'];
	}
	$sheet_url = is_string( $sheet_url ) ? trim( $sheet_url ) : '';
	$sheet_url = apply_filters( 'tasheel_hr_specialization_google_sheet_url', $sheet_url );

	if ( $sheet_url !== '' ) {
		$sheet_opts = tasheel_hr_fetch_specialization_from_google_sheet( $sheet_url );
		if ( ! empty( $sheet_opts ) ) {
			$opts = array( '' => __( 'Specialization', 'tasheel' ) );
			$opts = array_merge( $opts, $sheet_opts );
			return apply_filters( 'tasheel_hr_specialization_options', $opts );
		}
	}

	$opts = array(
		''          => __( 'Specialization', 'tasheel' ),
		'engineering' => __( 'Engineering', 'tasheel' ),
		'architecture' => __( 'Architecture', 'tasheel' ),
		'business'  => __( 'Business', 'tasheel' ),
		'science'   => __( 'Science', 'tasheel' ),
		'design'    => __( 'Design', 'tasheel' ),
		'law'       => __( 'Law', 'tasheel' ),
		'finance'   => __( 'Finance', 'tasheel' ),
		'project-management' => __( 'Project Management', 'tasheel' ),
		'other'     => __( 'Other', 'tasheel' ),
	);
	return apply_filters( 'tasheel_hr_specialization_options', $opts );
}

/**
 * Get human-readable label for a specialization value.
 *
 * @param string $value Stored value.
 * @return string
 */
function tasheel_hr_specialization_label( $value ) {
	if ( ! $value ) {
		return '';
	}
	$opts = tasheel_hr_specialization_options();
	return isset( $opts[ $value ] ) ? $opts[ $value ] : $value;
}

/**
 * Normalize job type slug (handles hyphen vs underscore variants from taxonomy).
 *
 * @param string $slug Raw term slug from job_type taxonomy.
 * @return string Normalized slug: career|corporate_training|academic, or 'career' if unknown/empty.
 */
function tasheel_hr_normalize_job_type_slug( $slug ) {
	$slug = $slug ? trim( (string) $slug ) : '';
	if ( '' === $slug ) {
		return 'career';
	}
	$map = array(
		'corporate_training' => 'corporate_training',
		'corporate-training' => 'corporate_training',
		'academic'           => 'academic',
		'academic-program'   => 'academic',
		'career'             => 'career',
	);
	return isset( $map[ $slug ] ) ? $map[ $slug ] : 'career';
}

/**
 * Required profile fields per job type (FRD: path-specific).
 * Used on Review Profile and Create Profile to validate mandatory fields per category.
 * All form fields mandatory except: Reason for leaving (in experience), LinkedIn URL, Portfolio.
 *
 * Mandatory fields by category:
 * - career: General + Resume, Education (full entries), Experience (full entries), Specialization,
 *   Years of experience, Notice period, Current/Expected salary, Visa status, Saudi Council,
 *   Currently/Previously employed at Saud Consult, Recent Projects (full entries). Conditional:
 *   if "Currently employed" = yes then Employee ID, Current Project, Department; if "Previously worked" = yes
 *   then Duration, Last Project, Previous Department.
 * - corporate_training: General + Resume, Education (full entries).
 * - academic: General + Resume, Education (full entries).
 *
 * @param string $job_type_slug career|corporate_training|academic
 * @return array Meta keys required for that type.
 */
function tasheel_hr_required_fields_for_job_type( $job_type_slug ) {
	$job_type_slug = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $job_type_slug ) : ( $job_type_slug ?: 'career' );
	$general = array( 'profile_title', 'profile_first_name', 'profile_last_name', 'profile_phone', 'profile_photo', 'profile_location', 'profile_gender', 'profile_dob', 'profile_national_status', 'profile_nationality', 'profile_marital_status' );
	$career  = array( 'profile_resume', 'profile_education', 'profile_experience', 'profile_specialization', 'profile_years_experience', 'profile_notice_period', 'profile_current_salary', 'profile_expected_salary', 'profile_visa_status', 'profile_currently_employed', 'profile_previously_worked', 'profile_recent_projects' );
	switch ( $job_type_slug ) {
		case 'corporate_training':
			return array_merge( $general, array( 'profile_resume', 'profile_education' ) );
		case 'academic':
			return array_merge( $general, array( 'profile_resume', 'profile_education' ) );
		case 'career':
		default:
			return array_merge( $general, $career );
	}
}

/**
 * Check if a value is effectively empty for required-field validation.
 * Treats whitespace-only strings and empty file arrays as empty.
 *
 * @param mixed  $val   Value from profile.
 * @param string $key   Profile meta key (for file fields).
 * @return bool True if value should be considered missing.
 */
function tasheel_hr_profile_value_is_empty( $val, $key = '' ) {
	if ( $val === null || $val === '' ) {
		return true;
	}
	if ( is_string( $val ) ) {
		return trim( $val ) === '';
	}
	if ( is_array( $val ) ) {
		if ( empty( $val ) ) {
			return true;
		}
		// File-type fields may be stored as array with 'url' or 'file'.
		$file_keys = array( 'profile_photo', 'profile_resume', 'profile_saudi_council' );
		if ( in_array( $key, $file_keys, true ) ) {
			$url = isset( $val['url'] ) ? trim( (string) $val['url'] ) : ( isset( $val['file'] ) ? trim( (string) $val['file'] ) : '' );
			return $url === '';
		}
		return false;
	}
	return empty( $val );
}

/**
 * Check if a profile array has all required fields for a job type (used before save when no job context = career).
 * Includes conditional validation: when "Currently employed" = yes, sub-fields are required; same for "Previously worked".
 * Profile photo is required only for logged-in users; for guests (user_id 0) it is not required.
 *
 * @param array  $profile       Profile data key => value (e.g. merged current + POST data).
 * @param string $job_type_slug career|corporate_training|academic
 * @param int    $user_id       Optional. When 0 (guest), profile_photo is not required.
 * @return array Empty if ok, else list of missing field keys.
 */
function tasheel_hr_profile_missing_required_from_data( $profile, $job_type_slug, $user_id = null ) {
	$required = tasheel_hr_required_fields_for_job_type( $job_type_slug );
	if ( $user_id === 0 ) {
		$required = array_diff( $required, array( 'profile_photo' ) );
	}
	$missing  = array();
	foreach ( $required as $key ) {
		$val = isset( $profile[ $key ] ) ? $profile[ $key ] : '';
		if ( $key === 'profile_recent_projects' ) {
			$arr = is_string( $val ) ? json_decode( $val, true ) : ( is_array( $val ) ? $val : array() );
			$arr = is_array( $arr ) ? $arr : array();
			if ( empty( $arr ) ) {
				$missing[] = $key;
				continue;
			}
			$has_valid = false;
			foreach ( $arr as $p ) {
				$p = is_array( $p ) ? $p : array();
				$company  = isset( $p['company'] ) ? trim( (string) $p['company'] ) : '';
				$client   = isset( $p['client'] ) ? trim( (string) $p['client'] ) : '';
				$period   = isset( $p['period'] ) ? trim( (string) $p['period'] ) : '';
				$position = isset( $p['position'] ) ? trim( (string) $p['position'] ) : '';
				$duties   = isset( $p['duties'] ) ? trim( (string) $p['duties'] ) : '';
				if ( $company !== '' && $client !== '' && $period !== '' && $position !== '' && $duties !== '' ) {
					$has_valid = true;
					break;
				}
			}
			if ( ! $has_valid ) {
				$missing[] = $key;
			}
			continue;
		}
		if ( $key === 'profile_education' ) {
			$arr = is_string( $val ) ? json_decode( $val, true ) : ( is_array( $val ) ? $val : array() );
			$arr = is_array( $arr ) ? $arr : array();
			if ( empty( $arr ) ) {
				$missing[] = $key;
				continue;
			}
			$edu_reqd = array( 'degree', 'institute', 'major', 'start_date', 'end_date', 'city', 'country', 'gpa', 'avg_grade', 'mode' );
			$has_valid = false;
			$all_complete = true;
			foreach ( $arr as $ei => $e ) {
				$e = is_array( $e ) ? $e : array();
				$institute = trim( (string) ( isset( $e['institute'] ) ? $e['institute'] : ( isset( $e['institution'] ) ? $e['institution'] : ( isset( $e['Institution'] ) ? $e['Institution'] : '' ) ) ) );
				$e['institute'] = $institute;
				$e['avg_grade'] = trim( (string) ( isset( $e['avg_grade'] ) ? $e['avg_grade'] : ( isset( $e['average_grade'] ) ? $e['average_grade'] : '' ) ) );
				$under_process = ! empty( $e['under_process'] );
				$all_filled = true;
				$any_filled = false;
				foreach ( $edu_reqd as $fk ) {
					if ( $fk === 'end_date' && $under_process ) {
						continue;
					}
					$v = isset( $e[ $fk ] ) ? trim( (string) $e[ $fk ] ) : '';
					if ( $v !== '' ) {
						$any_filled = true;
					} else {
						$all_filled = false;
						$missing[] = 'profile_education_' . (int) $ei . '_' . $fk;
					}
				}
				if ( $all_filled ) {
					$has_valid = true;
				}
				if ( $any_filled && ! $all_filled ) {
					$all_complete = false;
				}
			}
			if ( ! $has_valid || ! $all_complete ) {
				// Section-level key only when no entries at all; otherwise granular keys already added.
				if ( empty( $arr ) ) {
					$missing[] = $key;
				}
			}
			continue;
		}
		if ( $key === 'profile_experience' ) {
			$has_exp = isset( $profile['profile_has_experience'] ) ? $profile['profile_has_experience'] : '';
			if ( $has_exp === '0' || $has_exp === 0 || $has_exp === false ) {
				continue;
			}
			$arr = is_string( $val ) ? json_decode( $val, true ) : ( is_array( $val ) ? $val : array() );
			$arr = is_array( $arr ) ? $arr : array();
			if ( empty( $arr ) ) {
				$missing[] = $key;
				continue;
			}
			$has_valid    = false;
			$all_complete = true;
			$exp_reqd     = array( 'employer', 'job_title', 'start_date', 'end_date', 'country', 'years', 'salary', 'benefits' );
			foreach ( $arr as $xi => $x ) {
				$x = is_array( $x ) ? $x : array();
				$current_job = ! empty( $x['current_job'] );
				foreach ( $exp_reqd as $f ) {
					if ( $f === 'end_date' && $current_job ) {
						continue;
					}
					$v = isset( $x[ $f ] ) ? trim( (string) $x[ $f ] ) : '';
					if ( $v === '' ) {
						$missing[] = 'profile_experience_' . (int) $xi . '_' . $f;
					}
				}
				$vals = array();
				foreach ( $exp_reqd as $f ) {
					$vals[ $f ] = isset( $x[ $f ] ) ? trim( (string) $x[ $f ] ) : '';
				}
				$vals_for_complete = $vals;
				if ( $current_job ) {
					unset( $vals_for_complete['end_date'] );
				}
				$any_filled = array_filter( $vals );
				$all_filled = count( array_filter( $vals_for_complete ) ) === count( $vals_for_complete );
				if ( $all_filled ) {
					$has_valid = true;
				}
				if ( ! empty( $any_filled ) && ! $all_filled ) {
					$all_complete = false;
				}
			}
			if ( ! $has_valid || ! $all_complete ) {
				if ( empty( $arr ) ) {
					$missing[] = $key;
				}
			}
			continue;
		}
		// Phone: required and minimum length (same rule for Create Profile and Guest apply).
		if ( $key === 'profile_phone' ) {
			if ( tasheel_hr_profile_value_is_empty( $val, $key ) ) {
				$missing[] = $key;
			} elseif ( ! function_exists( 'tasheel_hr_profile_phone_is_valid' ) || ! tasheel_hr_profile_phone_is_valid( $val ) ) {
				$missing[] = $key;
			}
			continue;
		}
		// All other required fields: treat whitespace-only and empty arrays as missing.
		if ( tasheel_hr_profile_value_is_empty( $val, $key ) ) {
			$missing[] = $key;
		}
	}
	// Conditional: when "Currently employed" = yes, require sub-fields (career only).
	if ( $job_type_slug === 'career' ) {
		$curr = isset( $profile['profile_currently_employed'] ) ? trim( (string) $profile['profile_currently_employed'] ) : '';
		if ( strtolower( $curr ) === 'yes' ) {
			$cond = array( 'profile_employee_id', 'profile_current_project', 'profile_current_department' );
			foreach ( $cond as $ck ) {
				$cv = isset( $profile[ $ck ] ) ? $profile[ $ck ] : '';
				if ( empty( $cv ) || ( is_string( $cv ) && trim( $cv ) === '' ) ) {
					$missing[] = $ck;
				}
			}
		}
		$prev = isset( $profile['profile_previously_worked'] ) ? trim( (string) $profile['profile_previously_worked'] ) : '';
		if ( strtolower( $prev ) === 'yes' ) {
			$cond = array( 'profile_previous_duration', 'profile_last_project', 'profile_previous_department' );
			foreach ( $cond as $ck ) {
				$cv = isset( $profile[ $ck ] ) ? $profile[ $ck ] : '';
				if ( empty( $cv ) || ( is_string( $cv ) && trim( $cv ) === '' ) ) {
					$missing[] = $ck;
				}
			}
		}
	}
	return $missing;
}

/**
 * Check if user profile has required fields filled for a job type.
 *
 * @param int    $user_id       User ID.
 * @param string $job_type_slug career|corporate_training|academic
 * @return array Empty if ok, else list of missing field keys.
 */
function tasheel_hr_profile_missing_required_fields( $user_id, $job_type_slug ) {
	$profile = tasheel_hr_get_user_profile( $user_id );
	return tasheel_hr_profile_missing_required_from_data( $profile, $job_type_slug, $user_id );
}

/**
 * Profile meta keys to include in the application snapshot for a job type.
 * Snapshot shows only what was submitted for that job category; "View full profile in User" shows everything.
 *
 * @param string $job_type_slug career|corporate_training|academic
 * @return array List of profile_* keys (and profile_email) to store in application_snapshot.
 */
function tasheel_hr_snapshot_keys_for_job_type( $job_type_slug ) {
	$job_type_slug = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $job_type_slug ) : ( $job_type_slug ?: 'career' );
	$required = tasheel_hr_required_fields_for_job_type( $job_type_slug );
	$optional = array( 'profile_linkedin', 'profile_portfolio', 'profile_email' );
	$keys = array_unique( array_merge( $required, $optional ) );
	// Include employment sub-details and Saudi Council for career so they appear in submitted snapshot.
	if ( $job_type_slug === 'career' ) {
		$employment_sub = array( 'profile_employee_id', 'profile_current_project', 'profile_current_department', 'profile_previous_duration', 'profile_last_project', 'profile_previous_department' );
		$keys = array_merge( $keys, $employment_sub );
		$keys = array_merge( $keys, array( 'profile_saudi_council', 'profile_saudi_council_thumb' ) );
	}
	return $keys;
}

/**
 * Review sections to show on My Profile (Review & Submit) per job type (FRD 8.2: only job-relevant data).
 *
 * @param string $job_type_slug career|corporate_training|academic
 * @return array List of section IDs to display. Empty means show all sections (e.g. when no job context).
 */
function tasheel_hr_review_sections_for_job_type( $job_type_slug ) {
	$common = array( 'contact', 'diversity', 'documents' );
	switch ( $job_type_slug ) {
		case 'corporate_training':
			return array_merge( $common, array( 'education' ) );
		case 'academic':
			return array_merge( $common, array( 'education' ) );
		case 'career':
		default:
			return array_merge( $common, array( 'education', 'experience', 'saudi_council', 'additional_info', 'employment_history' ) );
	}
}

/**
 * Get profile data for a user (from user meta + WP user fields).
 * Prefills from WP user (first_name, last_name, user_email) when profile meta is empty.
 *
 * @param int $user_id User ID.
 * @return array Profile data keyed by meta key.
 */
function tasheel_hr_get_user_profile( $user_id ) {
	if ( ! $user_id ) {
		return array();
	}
	$user = get_userdata( $user_id );
	if ( ! $user ) {
		return array();
	}
	$keys = tasheel_hr_profile_meta_keys();
	$out  = array(
		'profile_email' => $user->user_email,
	);
	foreach ( $keys as $key ) {
		$val = get_user_meta( $user_id, $key, true );
		$out[ $key ] = is_string( $val ) ? $val : ( is_array( $val ) ? $val : '' );
	}
	// Prefill from WP user when profile meta is empty (e.g. right after registration).
	if ( empty( $out['profile_first_name'] ) && ! empty( $user->first_name ) ) {
		$out['profile_first_name'] = $user->first_name;
	}
	if ( empty( $out['profile_last_name'] ) && ! empty( $user->last_name ) ) {
		$out['profile_last_name'] = $user->last_name;
	}
	return $out;
}

/**
 * Decode literal Unicode escape sequences (e.g. u0627) to UTF-8 characters.
 * Used when profile JSON was saved with \uXXXX and backslashes were stripped, so Arabic shows as "u0627u0644" instead of real text.
 *
 * @param string $str String that may contain literal uXXXX sequences.
 * @return string Fixed string.
 */
function tasheel_hr_fix_unicode_display( $str ) {
	if ( ! is_string( $str ) || $str === '' ) {
		return $str;
	}
	return preg_replace_callback( '/u([0-9a-fA-F]{4})/', function( $m ) {
		$c = json_decode( '"\\u' . $m[1] . '"' );
		return $c !== null ? $c : $m[0];
	}, $str );
}

/**
 * Recursively fix Unicode display in all string values of a decoded profile JSON array (education, experience, projects, licenses).
 *
 * @param array|mixed $data Decoded array from json_decode( profile_education ), etc.
 * @return array|mixed Same structure with string values passed through tasheel_hr_fix_unicode_display.
 */
function tasheel_hr_fix_profile_json_strings( $data ) {
	if ( is_array( $data ) ) {
		$out = array();
		foreach ( $data as $k => $v ) {
			$out[ $k ] = tasheel_hr_fix_profile_json_strings( $v );
		}
		return $out;
	}
	if ( is_string( $data ) ) {
		return tasheel_hr_fix_unicode_display( $data );
	}
	return $data;
}

/**
 * AJAX: Return current user's profile for edit form (logged-in only). Used when create-profile page was cached empty.
 */
function tasheel_hr_ajax_get_profile_for_edit() {
	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => 'Unauthorized' ), 401 );
	}
	$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'tasheel_hr_profile_fetch' ) ) {
		wp_send_json_error( array( 'message' => 'Invalid nonce' ), 403 );
	}
	$profile = tasheel_hr_get_user_profile( get_current_user_id() );
	wp_send_json_success( $profile );
}
add_action( 'wp_ajax_tasheel_hr_get_profile_for_edit', 'tasheel_hr_ajax_get_profile_for_edit' );

/**
 * Save profile data to user meta. Syncs first/last name to WP user.
 *
 * @param int   $user_id User ID.
 * @param array $data    Associative array of meta_key => value.
 * @return bool True on success.
 */
function tasheel_hr_save_user_profile( $user_id, $data ) {
	if ( ! $user_id || ! is_array( $data ) ) {
		return false;
	}
	$keys = tasheel_hr_profile_meta_keys();
	foreach ( $keys as $key ) {
		if ( array_key_exists( $key, $data ) ) {
			$val = $data[ $key ];
			if ( is_array( $val ) ) {
				update_user_meta( $user_id, $key, $val );
			} else {
				update_user_meta( $user_id, $key, sanitize_text_field( $val ) );
			}
		}
	}
	// Sync first/last name to WP user (used in backend, emails, etc.).
	if ( array_key_exists( 'profile_first_name', $data ) || array_key_exists( 'profile_last_name', $data ) ) {
		wp_update_user( array(
			'ID'         => $user_id,
			'first_name' => isset( $data['profile_first_name'] ) ? sanitize_text_field( $data['profile_first_name'] ) : get_user_meta( $user_id, 'profile_first_name', true ),
			'last_name'  => isset( $data['profile_last_name'] ) ? sanitize_text_field( $data['profile_last_name'] ) : get_user_meta( $user_id, 'profile_last_name', true ),
		) );
	}
	return true;
}

/**
 * Assign Applicant role to a user (e.g. on registration from careers).
 *
 * @param int $user_id User ID.
 */
function tasheel_hr_assign_applicant_role( $user_id ) {
	if ( ! $user_id || ! defined( 'TASHEEL_HR_APPLICANT_ROLE' ) ) {
		return;
	}
	$user = get_userdata( $user_id );
	if ( ! $user ) {
		return;
	}
	if ( ! in_array( TASHEEL_HR_APPLICANT_ROLE, (array) $user->roles, true ) ) {
		$user->set_role( TASHEEL_HR_APPLICANT_ROLE );
	}
}

/**
 * Assign Applicant role when user registers from careers/apply flow.
 * Triggered when redirect_to contains create-profile, my-profile, or apply.
 * Also stores redirect_to in transient for registration_redirect filter (backup).
 */
function tasheel_hr_maybe_assign_applicant_on_register( $user_id ) {
	$redirect = isset( $_REQUEST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ) : '';
	$is_apply_flow = $redirect && (
		strpos( $redirect, 'create-profile' ) !== false ||
		strpos( $redirect, 'my-profile' ) !== false ||
		strpos( $redirect, 'apply_to=' ) !== false ||
		strpos( $redirect, '/apply/' ) !== false
	);
	if ( $is_apply_flow ) {
		tasheel_hr_assign_applicant_role( $user_id );
		set_transient( 'tasheel_registration_redirect_' . $user_id, $redirect, 60 );
	}
	if ( get_transient( 'tasheel_apply_register_' . $user_id ) ) {
		tasheel_hr_assign_applicant_role( $user_id );
		delete_transient( 'tasheel_apply_register_' . $user_id );
	}
}

add_action( 'user_register', 'tasheel_hr_maybe_assign_applicant_on_register', 10, 1 );

/**
 * Generate a unique WordPress username from an email (e.g. for signup when username field is not shown).
 *
 * @param string $email Valid email address.
 * @return string Sanitized unique username (max 60 chars).
 */
function tasheel_generate_username_from_email( $email ) {
	$local = substr( $email, 0, strpos( $email, '@' ) );
	$base  = preg_replace( '/[^a-zA-Z0-9_]/', '', $local );
	if ( strlen( $base ) < 2 ) {
		$base = 'user';
	}
	$base = substr( $base, 0, 60 );
	$login = $base;
	$i     = 0;
	while ( username_exists( $login ) ) {
		$i++;
		$suffix = (string) $i;
		$login  = substr( $base, 0, 60 - strlen( $suffix ) ) . $suffix;
	}
	return $login;
}

/**
 * Validate password strength: at least one uppercase, one lowercase, one digit, one special character. Min length 6.
 *
 * @param string $pass Raw password.
 * @return string|false Error message key or false if valid.
 */
function tasheel_validate_password_strength( $pass ) {
	if ( strlen( $pass ) < 6 ) {
		return 'password_short';
	}
	if ( ! preg_match( '/[a-z]/', $pass ) ) {
		return 'password_no_lowercase';
	}
	if ( ! preg_match( '/[A-Z]/', $pass ) ) {
		return 'password_no_uppercase';
	}
	if ( ! preg_match( '/[0-9]/', $pass ) ) {
		return 'password_no_digit';
	}
	if ( ! preg_match( '/[^a-zA-Z0-9]/', $pass ) ) {
		return 'password_no_special';
	}
	return false;
}

/**
 * Handle custom registration POST. Creates user with Applicant role, logs in, redirects to create profile.
 * Runs at init priority 0. Form posts to home URL so no plugin can redirect /create-profile/ to wp-login first.
 */
function tasheel_hr_handle_registration_post() {
	if ( $_SERVER['REQUEST_METHOD'] !== 'POST' || empty( $_POST['tasheel_register'] ) ) {
		return;
	}
	// Let AJAX handler process registration when action is tasheel_ajax_register (no redirect).
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && ! empty( $_POST['action'] ) && sanitize_text_field( wp_unslash( $_POST['action'] ) ) === 'tasheel_ajax_register' ) {
		return;
	}
	if ( empty( $_POST['tasheel_register_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tasheel_register_nonce'] ) ), 'tasheel_register' ) ) {
		return;
	}
	$default_redirect = function_exists( 'tasheel_hr_create_profile_url' ) ? tasheel_hr_create_profile_url() : home_url( '/create-profile/' );
	$redirect_to = isset( $_POST['redirect_to'] ) ? tasheel_validate_redirect_same_site( esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ), $default_redirect ) : $default_redirect;

	$login = isset( $_POST['user_login'] ) ? sanitize_user( wp_unslash( $_POST['user_login'] ), true ) : '';
	$email = isset( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';
	$pass  = isset( $_POST['user_pass'] ) ? ( is_array( $_POST['user_pass'] ) ? '' : (string) $_POST['user_pass'] ) : '';
	$email_confirm = isset( $_POST['user_email_confirm'] ) ? sanitize_email( wp_unslash( $_POST['user_email_confirm'] ) ) : '';
	$pass_confirm  = isset( $_POST['user_pass_confirm'] ) ? ( is_array( $_POST['user_pass_confirm'] ) ? '' : (string) $_POST['user_pass_confirm'] ) : '';
	$first = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$last  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';

	if ( ! $email ) {
		return;
	}
	if ( ! $login && is_email( $email ) ) {
		$login = tasheel_generate_username_from_email( $email );
	}
	$errors = new WP_Error();
	if ( strlen( $login ) > 60 ) {
		$errors->add( 'username_length', __( 'Username is too long.', 'tasheel' ) );
	}
	if ( ! is_email( $email ) ) {
		$errors->add( 'invalid_email', __( 'Please enter a valid email address.', 'tasheel' ) );
	}
	if ( $email_confirm !== '' && $email_confirm !== $email ) {
		$errors->add( 'email_mismatch', __( 'Email addresses do not match.', 'tasheel' ) );
	}
	if ( ! $pass_confirm ) {
		$errors->add( 'password_confirm_empty', __( 'Please retype your password.', 'tasheel' ) );
	} elseif ( $pass_confirm !== $pass ) {
		$errors->add( 'password_mismatch', __( 'Passwords do not match.', 'tasheel' ) );
	}
	if ( username_exists( $login ) ) {
		$errors->add( 'username_exists', __( 'This username is already registered.', 'tasheel' ) );
	}
	if ( email_exists( $email ) ) {
		$errors->add( 'email_exists', __( 'This email is already registered.', 'tasheel' ) );
	}
	$pass_strength = $pass ? tasheel_validate_password_strength( $pass ) : false;
	if ( $pass && $pass_strength === 'password_short' ) {
		$errors->add( 'password_short', __( 'Password must be at least 6 characters.', 'tasheel' ) );
	} elseif ( $pass && ( $pass_strength === 'password_no_lowercase' || $pass_strength === 'password_no_uppercase' ) ) {
		$errors->add( 'password_strength', __( 'Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.', 'tasheel' ) );
	} elseif ( $pass && ( $pass_strength === 'password_no_digit' || $pass_strength === 'password_no_special' ) ) {
		$errors->add( 'password_strength', __( 'Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.', 'tasheel' ) );
	}
	if ( strlen( $first ) > 50 ) {
		$first = substr( $first, 0, 50 );
	}
	if ( strlen( $last ) > 50 ) {
		$last = substr( $last, 0, 50 );
	}
	if ( $errors->has_errors() ) {
		$key = 'tasheel_registration_errors_' . wp_create_nonce( 'reg' );
		set_transient( $key, $errors->get_error_messages(), 120 );
		wp_safe_redirect( add_query_arg( array( 'registration_error' => '1', 'errkey' => $key ), $redirect_to ) );
		exit;
	}
	$user_id = wp_insert_user( array(
		'user_login'   => $login,
		'user_email'   => $email,
		'user_pass'    => $pass,
		'first_name'   => $first,
		'last_name'    => $last,
		'display_name' => trim( $first . ' ' . $last ) ?: $login,
		'role'         => 'subscriber',
	) );
	if ( is_wp_error( $user_id ) ) {
		$key = 'tasheel_registration_errors_' . wp_create_nonce( 'reg' );
		set_transient( $key, array( $user_id->get_error_message() ), 120 );
		wp_safe_redirect( add_query_arg( array( 'registration_error' => '1', 'errkey' => $key ), $redirect_to ) );
		exit;
	}
	if ( function_exists( 'tasheel_hr_register_applicant_role' ) ) {
		tasheel_hr_register_applicant_role();
	}
	if ( defined( 'TASHEEL_HR_APPLICANT_ROLE' ) && get_role( TASHEEL_HR_APPLICANT_ROLE ) ) {
		$user = get_userdata( $user_id );
		if ( $user ) {
			$user->set_role( TASHEEL_HR_APPLICANT_ROLE );
		}
	}
	$emails_sent = false;
	try {
		if ( function_exists( 'tasheel_do_send_new_user_notifications' ) ) {
			tasheel_do_send_new_user_notifications( $user_id );
			$emails_sent = true;
		}
	} catch ( Throwable $e ) {
		if ( function_exists( 'error_log' ) ) {
			error_log( 'tasheel_hr_handle_registration_post inline email: ' . $e->getMessage() );
		}
	}
	if ( ! $emails_sent ) {
		wp_schedule_single_event( time(), 'tasheel_send_new_user_notifications', array( $user_id ) );
		if ( function_exists( 'tasheel_spawn_cron' ) ) {
			tasheel_spawn_cron();
		}
	}
	wp_clear_auth_cookie();
	wp_set_current_user( $user_id );
	wp_set_auth_cookie( $user_id, true );
	wp_safe_redirect( $redirect_to );
	exit;
}

add_action( 'init', 'tasheel_hr_handle_registration_post', 0 );

/**
 * Start output buffering for registration AJAX as early as possible so any output from
 * WordPress, plugins, or hooks (e.g. wp_mail) does not corrupt the JSON response.
 */
function tasheel_ajax_register_ob_start() {
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && ! empty( $_REQUEST['action'] ) && sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) === 'tasheel_ajax_register' ) {
		ob_start();
		register_shutdown_function( 'tasheel_ajax_register_shutdown' );
	}
}
add_action( 'init', 'tasheel_ajax_register_ob_start', -1 );

/**
 * On fatal error during registration AJAX, send JSON instead of WordPress critical error HTML
 * so the frontend can show a message and not get 500. Log the real error for debugging.
 */
function tasheel_ajax_register_shutdown() {
	if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX || empty( $_REQUEST['action'] ) || sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) !== 'tasheel_ajax_register' ) {
		return;
	}
	$err = error_get_last();
	if ( ! $err || ! in_array( $err['type'], array( E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR ), true ) ) {
		return;
	}
	if ( function_exists( 'error_log' ) ) {
		error_log( 'tasheel_ajax_register fatal: ' . $err['message'] . ' in ' . $err['file'] . ':' . $err['line'] );
	}
	while ( ob_get_level() > 0 ) {
		ob_end_clean();
	}
	header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	header( 'X-Robots-Tag: noindex' );
	echo wp_json_encode( array( 'success' => false, 'data' => array( 'message' => __( 'Something went wrong. Please try again.', 'tasheel' ) ) ) );
	exit;
}

/**
 * Professional HTML email template: welcome email to the new user.
 *
 * @param WP_User $user User object.
 * @return string HTML body.
 */
function tasheel_get_welcome_email_to_user_html( $user ) {
	$site_name  = get_bloginfo( 'name' );
	$login_url  = home_url( '/my-profile/' );
	$name       = trim( $user->first_name . ' ' . $user->last_name ) ?: $user->display_name;
	if ( ! $name ) {
		$name = $user->user_login;
	}
	$title   = sprintf( __( 'Welcome to %s', 'tasheel' ), $site_name );
	$subtitle = __( 'You have received a message from your website', 'tasheel' );
	$body    = '<p style="margin: 0 0 16px; font-size: 16px; color: #333;">' . sprintf( esc_html__( 'Hello %s,', 'tasheel' ), esc_html( $name ) ) . '</p>';
	$body   .= '<p style="margin: 0 0 20px; font-size: 16px; color: #333;">' . sprintf( esc_html__( 'Thank you for creating an account with %s. Your registration was successful.', 'tasheel' ), esc_html( $site_name ) ) . '</p>';
	$body   .= '<p style="margin: 0; font-size: 16px; color: #333;">' . esc_html__( 'You can sign in anytime at:', 'tasheel' ) . ' <a href="' . esc_url( $login_url ) . '" style="color: #0D6A37; font-weight: 600;">' . esc_html( $login_url ) . '</a></p>';
	return tasheel_get_email_html_wrapper( $title, $subtitle, $body );
}

/**
 * Professional HTML email template: new user notification to admin.
 *
 * @param WP_User $user User object.
 * @return string HTML body.
 */
function tasheel_get_new_user_admin_email_html( $user ) {
	$site_name   = get_bloginfo( 'name' );
	$admin_url   = admin_url( 'user-edit.php?user_id=' . $user->ID );
	$name        = trim( $user->first_name . ' ' . $user->last_name ) ?: $user->display_name;
	if ( ! $name ) {
		$name = $user->user_login;
	}
	$registered_date  = get_date_from_gmt( $user->user_registered );
	$registered_local  = $registered_date ? date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $registered_date ) ) : $user->user_registered;

	$title   = __( 'New user registration', 'tasheel' );
	$subtitle = sprintf( __( 'You have received a message from %s', 'tasheel' ), $site_name );
	$body    = '<p style="margin: 0 0 20px; font-size: 16px; color: #333;">' . esc_html__( 'A new user has registered on your site.', 'tasheel' ) . '</p>';
	$body   .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 24px;">';
	$body   .= '<tr><td style="padding: 15px; background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;"><div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">' . esc_html__( 'Name', 'tasheel' ) . '</div><div style="font-size: 16px; color: #0D6A37; font-weight: 600;">' . esc_html( $name ) . '</div></td></tr>';
	$body   .= '<tr><td style="padding: 15px; background-color: #ffffff; border-bottom: 2px solid #e9ecef;"><div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">' . esc_html__( 'Username', 'tasheel' ) . '</div><div style="font-size: 16px; color: #0D6A37; font-weight: 600;">' . esc_html( $user->user_login ) . '</div></td></tr>';
	$body   .= '<tr><td style="padding: 15px; background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;"><div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">' . esc_html__( 'Email', 'tasheel' ) . '</div><div style="font-size: 16px;"><a href="mailto:' . esc_attr( $user->user_email ) . '" style="color: #0D6A37; text-decoration: none; font-weight: 600;">' . esc_html( $user->user_email ) . '</a></div></td></tr>';
	$body   .= '<tr><td style="padding: 15px; background-color: #ffffff; border-bottom: 2px solid #e9ecef;"><div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">' . esc_html__( 'Registered', 'tasheel' ) . '</div><div style="font-size: 16px; color: #0D6A37; font-weight: 600;">' . esc_html( $registered_local ) . '</div></td></tr>';
	$body   .= '</table>';
	$body   .= '<p style="margin: 0;"><a href="' . esc_url( $admin_url ) . '" target="_blank" style="display: inline-block; padding: 12px 24px; font-size: 14px; font-weight: 600; color: #ffffff !important; background-color: #0D6A37; border-radius: 6px; text-decoration: none;">' . esc_html__( 'View user in admin', 'tasheel' ) . '</a></p>';
	return tasheel_get_email_html_wrapper( $title, $subtitle, $body );
}

/**
 * Send HTML email with proper content type. Restores previous content type after send.
 *
 * @param string $to      Recipient email.
 * @param string $subject Subject line.
 * @param string $html    HTML body.
 * @return bool Whether the email was sent.
 */
function tasheel_send_html_email( $to, $subject, $html ) {
	$set_content_type = function( $type ) {
		return 'text/html';
	};
	add_filter( 'wp_mail_content_type', $set_content_type );
	$sent = wp_mail( $to, $subject, $html );
	remove_filter( 'wp_mail_content_type', $set_content_type );
	return $sent;
}

/**
 * Cron action: send new user notification emails (admin + user) in a separate request.
 * Sends custom professional HTML emails to both the new user and the admin.
 */
function tasheel_do_send_new_user_notifications( $user_id ) {
	$user_id = absint( $user_id );
	$user = $user_id ? get_userdata( $user_id ) : null;
	if ( ! $user || ! $user->user_email ) {
		return;
	}

	$site_name = get_bloginfo( 'name' );

	// 1. Welcome email to the new user (so they always receive it).
	$user_subject = sprintf(
		/* translators: %s: site name */
		__( 'Welcome to %s', 'tasheel' ),
		$site_name
	);
	$user_html = tasheel_get_welcome_email_to_user_html( $user );
	tasheel_send_html_email( $user->user_email, $user_subject, $user_html );

	// 2. New user notification to configured email(s) and always include admin as fallback.
	$recipients = array();
	$emails_field = null;
	if ( function_exists( 'get_field' ) ) {
		$emails_field = get_field( 'user_registration_notification_emails', 'acf-options-account' );
		if ( ( $emails_field === null || $emails_field === false || $emails_field === '' ) ) {
			$emails_field = get_field( 'user_registration_notification_emails', 'option' );
		}
	}
	if ( ( $emails_field === null || $emails_field === false || $emails_field === '' ) && function_exists( 'get_option' ) ) {
		$opts = get_option( 'options_acf-options-account', array() );
		$emails_field = ( is_array( $opts ) && isset( $opts['user_registration_notification_emails'] ) ) ? $opts['user_registration_notification_emails'] : '';
	}
	// Normalize: ACF can return string (textarea) or array (e.g. some configs).
	$emails_string = is_array( $emails_field ) ? implode( ',', $emails_field ) : ( is_string( $emails_field ) ? $emails_field : '' );
	$emails_string = is_string( $emails_string ) ? trim( $emails_string ) : '';
	// Support comma- or newline-separated (ACF textarea often has one email per line).
	if ( $emails_string !== '' ) {
		$emails_string = preg_replace( '/[\r\n]+/', ',', $emails_string );
		$recipients   = array_map( 'trim', explode( ',', $emails_string ) );
		$recipients   = array_filter( $recipients, 'is_email' );
	}
	$admin_email = get_option( 'admin_email' );
	if ( is_email( $admin_email ) && ! in_array( $admin_email, $recipients, true ) ) {
		$recipients[] = $admin_email;
	}
	if ( empty( $recipients ) && is_email( $admin_email ) ) {
		$recipients = array( $admin_email );
	}
	$recipients = array_filter( $recipients, 'is_email' );
	if ( ! empty( $recipients ) ) {
		$admin_subject = sprintf(
			/* translators: 1: site name, 2: user login */
			__( '[%1$s] New user registration: %2$s', 'tasheel' ),
			$site_name,
			$user->user_login
		);
		$admin_html = tasheel_get_new_user_admin_email_html( $user );
		// Send one email to all recipients (To: address1, address2, ...) instead of separate emails.
		tasheel_send_html_email( $recipients, $admin_subject, $admin_html );
	}
}
add_action( 'tasheel_send_new_user_notifications', 'tasheel_do_send_new_user_notifications', 10, 1 );

/**
 * Trigger WordPress cron in a non-blocking request (spawn). Used after scheduling registration emails.
 */
function tasheel_spawn_cron() {
	$url = add_query_arg( 'doing_wp_cron', time(), site_url( 'wp-cron.php' ) );
	wp_remote_post(
		$url,
		array(
			'timeout'   => 0.01,
			'blocking'  => false,
			'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
		)
	);
}

/**
 * Discard output buffer if one was started (e.g. by tasheel_ajax_register_ob_start). Safe to call multiple times.
 */
function tasheel_ajax_register_ob_clean() {
	while ( ob_get_level() > 0 ) {
		ob_end_clean();
	}
}

/**
 * Validate redirect URL to same site only (prevents open redirect). Returns safe URL or default.
 *
 * @param string $redirect Requested redirect URL.
 * @param string $default   Default if invalid.
 * @return string Safe redirect URL.
 */
function tasheel_validate_redirect_same_site( $redirect, $default ) {
	if ( ! is_string( $redirect ) || $redirect === '' ) {
		return $default;
	}
	$allowed = wp_validate_redirect( $redirect, $default );
	return $allowed ? $allowed : $default;
}

/**
 * AJAX: Register new user. Returns JSON so errors can be shown in the signup popup without redirect.
 * Production: nonce (CSRF), sanitization, validation, username/email exists, safe redirect, email with or without cron.
 */
function tasheel_ajax_register() {
	try {
		// Nonce first (CSRF).
		if ( empty( $_POST['tasheel_register_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tasheel_register_nonce'] ) ), 'tasheel_register' ) ) {
			tasheel_ajax_register_ob_clean();
			wp_send_json_error( array( 'message' => __( 'Your session expired. Please close the popup and try again.', 'tasheel' ) ) );
		}

		$default_redirect = function_exists( 'tasheel_hr_create_profile_url' ) ? tasheel_hr_create_profile_url() : home_url( '/create-profile/' );
		$redirect_to = isset( $_POST['redirect_to'] ) ? tasheel_validate_redirect_same_site( esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ), $default_redirect ) : $default_redirect;

		// Sanitize: WordPress uses these; prevents XSS and invalid data.
		$login = isset( $_POST['user_login'] ) ? sanitize_user( wp_unslash( $_POST['user_login'] ), true ) : '';
		$email = isset( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';
		$pass  = isset( $_POST['user_pass'] ) ? ( is_array( $_POST['user_pass'] ) ? '' : (string) $_POST['user_pass'] ) : '';
		$email_confirm = isset( $_POST['user_email_confirm'] ) ? sanitize_email( wp_unslash( $_POST['user_email_confirm'] ) ) : '';
		$pass_confirm  = isset( $_POST['user_pass_confirm'] ) ? ( is_array( $_POST['user_pass_confirm'] ) ? '' : (string) $_POST['user_pass_confirm'] ) : '';
		$first = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
		$last  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';

		if ( ! $login && is_email( $email ) ) {
			$login = tasheel_generate_username_from_email( $email );
		}

		// Per-field errors for display under each input (key = field name).
		$field_errors = array();
		if ( ! $email ) {
			$field_errors['user_email'] = __( 'Please enter your email address.', 'tasheel' );
		}
		if ( $login && strlen( $login ) > 60 ) {
			$field_errors['user_login'] = __( 'Username is too long.', 'tasheel' );
		}
		if ( $email && ! is_email( $email ) ) {
			$field_errors['user_email'] = __( 'Please enter a valid email address.', 'tasheel' );
		}
		if ( $email_confirm !== '' && $email_confirm !== $email ) {
			$field_errors['user_email_confirm'] = __( 'Email addresses do not match.', 'tasheel' );
		}
		if ( ! $pass ) {
			$field_errors['user_pass'] = __( 'Please choose a password.', 'tasheel' );
		}
		if ( ! $pass_confirm ) {
			$field_errors['user_pass_confirm'] = __( 'Please retype your password.', 'tasheel' );
		} elseif ( $pass_confirm !== $pass ) {
			$field_errors['user_pass_confirm'] = __( 'Passwords do not match.', 'tasheel' );
		}
		$pass_strength = $pass ? tasheel_validate_password_strength( $pass ) : false;
		if ( $pass && $pass_strength === 'password_short' ) {
			$field_errors['user_pass'] = __( 'Password must be at least 6 characters.', 'tasheel' );
		} elseif ( $pass && $pass_strength ) {
			$field_errors['user_pass'] = __( 'Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.', 'tasheel' );
		}
		if ( $pass && strlen( $pass ) > 4096 ) {
			$field_errors['user_pass'] = __( 'Password is too long.', 'tasheel' );
		}
		if ( ! $first ) {
			$field_errors['first_name'] = __( 'Please enter your first name.', 'tasheel' );
		}
		if ( ! $last ) {
			$field_errors['last_name'] = __( 'Please enter your last name.', 'tasheel' );
		}
		if ( strlen( $first ) > 50 ) {
			$first = substr( $first, 0, 50 );
		}
		if ( strlen( $last ) > 50 ) {
			$last = substr( $last, 0, 50 );
		}
		if ( $login && username_exists( $login ) ) {
			$field_errors['user_login'] = __( 'This username is already registered.', 'tasheel' );
		}
		if ( $email && is_email( $email ) && email_exists( $email ) ) {
			$field_errors['user_email'] = __( 'This email is already registered.', 'tasheel' );
		}
		if ( ! empty( $field_errors ) ) {
			tasheel_ajax_register_ob_clean();
			$first_message = reset( $field_errors );
			wp_send_json_error( array( 'message' => $first_message, 'errors' => $field_errors ) );
		}

		$user_id = wp_insert_user( array(
			'user_login'   => $login,
			'user_email'   => $email,
			'user_pass'    => $pass,
			'first_name'   => $first,
			'last_name'    => $last,
			'display_name' => trim( $first . ' ' . $last ) ?: $login,
			'role'         => 'subscriber',
		) );
		if ( is_wp_error( $user_id ) ) {
			tasheel_ajax_register_ob_clean();
			wp_send_json_error( array( 'message' => $user_id->get_error_message() ) );
		}
		if ( function_exists( 'tasheel_hr_register_applicant_role' ) ) {
			tasheel_hr_register_applicant_role();
		}
		if ( defined( 'TASHEEL_HR_APPLICANT_ROLE' ) && get_role( TASHEEL_HR_APPLICANT_ROLE ) ) {
			$user = get_userdata( $user_id );
			if ( $user ) {
				$user->set_role( TASHEEL_HR_APPLICANT_ROLE );
			}
		}

		// Emails: try inline first (works when cron is disabled); on failure schedule cron so redirect never breaks.
		$emails_sent = false;
		try {
			if ( function_exists( 'tasheel_do_send_new_user_notifications' ) ) {
				tasheel_do_send_new_user_notifications( $user_id );
				$emails_sent = true;
			}
		} catch ( Throwable $e ) {
			if ( function_exists( 'error_log' ) ) {
				error_log( 'tasheel_ajax_register inline email: ' . $e->getMessage() );
			}
		}
		if ( ! $emails_sent ) {
			wp_schedule_single_event( time(), 'tasheel_send_new_user_notifications', array( $user_id ) );
			if ( function_exists( 'tasheel_spawn_cron' ) ) {
				tasheel_spawn_cron();
			}
		}

		wp_clear_auth_cookie();
		wp_set_current_user( $user_id );
		wp_set_auth_cookie( $user_id, true );
		tasheel_ajax_register_ob_clean();
		wp_send_json_success( array( 'redirect_to' => $redirect_to ) );

	} catch ( Throwable $e ) {
		if ( function_exists( 'error_log' ) ) {
			error_log( 'tasheel_ajax_register: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine() );
		}
		tasheel_ajax_register_ob_clean();
		wp_send_json_error( array( 'message' => __( 'Something went wrong. Please try again.', 'tasheel' ) ) );
	}
}

add_action( 'wp_ajax_tasheel_ajax_register', 'tasheel_ajax_register' );
add_action( 'wp_ajax_nopriv_tasheel_ajax_register', 'tasheel_ajax_register' );

/**
 * Build profile data array from current $_POST and $_FILES (for save profile request).
 * Used by both init POST handler and AJAX save handler.
 *
 * @return array Profile data array (may be empty if request invalid).
 */
function tasheel_hr_build_profile_data_from_request() {
	$keys = array_keys( tasheel_hr_profile_meta_keys() );
	$data = array();
	foreach ( $keys as $key ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw = $_POST[ $key ];
		// Only read scalar fields here; compound fields (education, experience, etc.) are built below.
		if ( is_array( $raw ) ) {
			continue;
		}
		$data[ $key ] = tasheel_hr_sanitize_profile_scalar( $key, wp_unslash( $raw ) );
	}
	// Handle remove-file requests.
	$remove_keys = array( 'remove_profile_resume', 'remove_profile_portfolio', 'remove_profile_saudi_council', 'remove_profile_photo' );
	foreach ( $remove_keys as $rkey ) {
		if ( ! empty( $_POST[ $rkey ] ) ) {
			$meta_key = str_replace( 'remove_', '', $rkey );
			$data[ $meta_key ] = '';
			if ( 'profile_saudi_council' === $meta_key ) {
				$data['profile_saudi_council_thumb'] = '';
			}
		}
	}
	// Handle file uploads (resume, portfolio, saudi council, photo).
	require_once ABSPATH . 'wp-admin/includes/file.php';
	// Reset file validation errors so save handler can read them (invalid size/type = skip upload).
	if ( function_exists( 'tasheel_hr_set_profile_file_validation_errors' ) ) {
		tasheel_hr_set_profile_file_validation_errors( array() );
	}
	$file_fields = array(
		'profile_photo'            => array( 'name' => 'profile_photo', 'exts' => array( 'jpg', 'jpeg', 'png' ), 'max_mb' => 1 ),
		'profile_resume'           => array( 'name' => 'profile_resume', 'exts' => array( 'pdf', 'doc', 'docx' ), 'max_mb' => 5 ),
		'profile_portfolio'        => array( 'name' => 'profile_portfolio', 'exts' => array( 'pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png' ), 'max_mb' => 5 ),
		'profile_saudi_council'    => array( 'name' => 'saudi_council_certificate', 'exts' => array( 'pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png' ), 'max_mb' => 5 ),
	);
	foreach ( $file_fields as $meta_key => $config ) {
		$file_key = $config['name'];
		if ( empty( $_FILES[ $file_key ]['name'] ) || ! isset( $_FILES[ $file_key ]['error'] ) || $_FILES[ $file_key ]['error'] !== UPLOAD_ERR_OK ) {
			continue;
		}
		$ext = strtolower( pathinfo( $_FILES[ $file_key ]['name'], PATHINFO_EXTENSION ) );
		if ( ! in_array( $ext, $config['exts'], true ) ) {
			if ( function_exists( 'tasheel_hr_append_profile_file_validation_error' ) ) {
				$err = ( $meta_key === 'profile_photo' )
					? __( 'Only PNG, JPG and JPEG images are allowed. Max 1MB.', 'tasheel' )
					: ( function_exists( 'tasheel_hr_validate_profile_document_upload' ) ? tasheel_hr_validate_profile_document_upload( $file_key, $config['exts'], $config['max_mb'] ) : __( 'Please upload a file with allowed type (see below). Max ' . ( isset( $config['max_mb'] ) ? $config['max_mb'] : 5 ) . 'MB.', 'tasheel' ) );
				if ( $err !== '' ) {
					tasheel_hr_append_profile_file_validation_error( $meta_key, $err );
				}
			}
			continue;
		}
		$max_mb = isset( $config['max_mb'] ) ? (int) $config['max_mb'] : 5;
		if ( $meta_key !== 'profile_photo' && function_exists( 'tasheel_hr_validate_profile_document_upload' ) ) {
			$err = tasheel_hr_validate_profile_document_upload( $file_key, $config['exts'], $max_mb );
			if ( $err !== '' ) {
				if ( function_exists( 'tasheel_hr_append_profile_file_validation_error' ) ) {
					tasheel_hr_append_profile_file_validation_error( $meta_key, $err );
				}
				continue;
			}
		}
		if ( $meta_key === 'profile_photo' && function_exists( 'tasheel_hr_validate_profile_photo_upload' ) ) {
			$photo_err = tasheel_hr_validate_profile_photo_upload();
			if ( $photo_err !== '' ) {
				if ( function_exists( 'tasheel_hr_append_profile_file_validation_error' ) ) {
					tasheel_hr_append_profile_file_validation_error( 'profile_photo', $photo_err );
				}
				continue;
			}
		}
		$upload = wp_handle_upload( $_FILES[ $file_key ], array( 'test_form' => false ) );
		if ( isset( $upload['url'] ) ) {
			$data[ $meta_key ] = $upload['url'];
			// Generate thumbnail for Saudi Council PDF/DOC.
			if ( 'profile_saudi_council' === $meta_key && isset( $upload['file'] ) ) {
				$thumb_url = tasheel_hr_generate_document_thumbnail( $upload['file'], $ext );
				if ( $thumb_url ) {
					$data['profile_saudi_council_thumb'] = $thumb_url;
				}
			}
		}
	}
	// Build JSON arrays from compound form fields (education, experience, licenses, recent projects).
	$edu = array();
	$edu_post = isset( $_POST['profile_education'] ) && is_array( $_POST['profile_education'] ) ? wp_unslash( $_POST['profile_education'] ) : array();
	if ( ! empty( $edu_post ) ) {
		foreach ( $edu_post as $i => $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$degree    = isset( $row['degree'] ) ? sanitize_text_field( $row['degree'] ) : '';
			$institute = isset( $row['institute'] ) ? sanitize_text_field( $row['institute'] ) : '';
			// Include every row so validation errors for "add more" blocks (e.g. index 1) have a block to display.
			$edu[] = array(
				'degree'        => $degree,
				'institute'     => $institute,
				'major'         => isset( $row['major'] ) ? sanitize_text_field( $row['major'] ) : '',
				'start_date'    => isset( $row['start_date'] ) ? sanitize_text_field( $row['start_date'] ) : '',
				'end_date'      => isset( $row['end_date'] ) ? sanitize_text_field( $row['end_date'] ) : '',
				'city'          => isset( $row['city'] ) ? sanitize_text_field( $row['city'] ) : '',
				'country'       => isset( $row['country'] ) ? sanitize_text_field( $row['country'] ) : '',
				'gpa'           => isset( $row['gpa'] ) ? sanitize_text_field( $row['gpa'] ) : '',
				'avg_grade'     => isset( $row['avg_grade'] ) ? sanitize_text_field( $row['avg_grade'] ) : '',
				'mode'          => isset( $row['mode'] ) ? sanitize_text_field( $row['mode'] ) : '',
				'under_process' => ! empty( $row['under_process'] ) ? '1' : '',
			);
		}
	}
	if ( empty( $edu ) && ( ! empty( $_POST['profile_education_degree'] ) || ! empty( $_POST['profile_education_institute'] ) ) ) {
		$edu[] = array(
			'degree'        => isset( $_POST['profile_education_degree'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_degree'] ) ) : '',
			'institute'     => isset( $_POST['profile_education_institute'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_institute'] ) ) : '',
			'major'         => isset( $_POST['profile_education_major'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_major'] ) ) : '',
			'start_date'    => isset( $_POST['profile_education_start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_start_date'] ) ) : '',
			'end_date'      => isset( $_POST['profile_education_end_date'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_end_date'] ) ) : '',
			'city'          => isset( $_POST['profile_education_city'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_city'] ) ) : '',
			'country'       => isset( $_POST['profile_education_country'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_country'] ) ) : '',
			'gpa'           => isset( $_POST['profile_education_gpa'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_gpa'] ) ) : '',
			'avg_grade'     => isset( $_POST['profile_education_avg_grade'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_avg_grade'] ) ) : '',
			'mode'          => isset( $_POST['profile_education_mode'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_education_mode'] ) ) : '',
			'under_process' => ! empty( $_POST['profile_education_under_process'] ) ? '1' : '',
		);
	}
	if ( ! empty( $edu ) ) {
		$data['profile_education'] = wp_json_encode( $edu, JSON_UNESCAPED_UNICODE );
	}
	$has_experience = isset( $_POST['profile_has_experience'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_has_experience'] ) ) : '1';
	$data['profile_has_experience'] = ( $has_experience === '1' || $has_experience === 'yes' ) ? '1' : '0';
	$exp = array();
	if ( $data['profile_has_experience'] === '0' ) {
		$data['profile_experience'] = '';
	} else {
	$exp_post = isset( $_POST['profile_experience'] ) && is_array( $_POST['profile_experience'] ) ? wp_unslash( $_POST['profile_experience'] ) : array();
	if ( ! empty( $exp_post ) ) {
		foreach ( $exp_post as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$employer  = isset( $row['employer'] ) ? sanitize_text_field( $row['employer'] ) : '';
			$job_title = isset( $row['job_title'] ) ? sanitize_text_field( $row['job_title'] ) : '';
			// Include every row so validation errors for "add more" blocks have a block to display.
			$exp[] = array(
				'employer'       => $employer,
				'job_title'      => $job_title,
				'start_date'     => isset( $row['start_date'] ) ? sanitize_text_field( $row['start_date'] ) : '',
				'end_date'       => isset( $row['end_date'] ) ? sanitize_text_field( $row['end_date'] ) : '',
				'country'        => isset( $row['country'] ) ? sanitize_text_field( $row['country'] ) : '',
				'years'          => isset( $row['years'] ) ? sanitize_text_field( $row['years'] ) : '',
				'salary'         => isset( $row['salary'] ) ? sanitize_text_field( $row['salary'] ) : '',
				'benefits'       => isset( $row['benefits'] ) ? sanitize_text_field( $row['benefits'] ) : '',
				'reason_leaving' => isset( $row['reason_leaving'] ) ? tasheel_hr_sanitize_profile_textarea( $row['reason_leaving'] ) : '',
				'current_job'    => ! empty( $row['current_job'] ) ? '1' : '',
			);
		}
	}
	if ( empty( $exp ) && ( ! empty( $_POST['profile_experience_employer'] ) || ! empty( $_POST['profile_experience_job_title'] ) ) ) {
		$exp[] = array(
			'employer'       => isset( $_POST['profile_experience_employer'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_experience_employer'] ) ) : '',
			'job_title'      => isset( $_POST['profile_experience_job_title'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_experience_job_title'] ) ) : '',
			'start_date'     => isset( $_POST['profile_experience_start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_experience_start_date'] ) ) : '',
			'end_date'       => isset( $_POST['profile_experience_end_date'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_experience_end_date'] ) ) : '',
			'country'        => isset( $_POST['profile_experience_country'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_experience_country'] ) ) : '',
			'years'          => isset( $_POST['profile_experience_years'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_experience_years'] ) ) : '',
			'salary'         => isset( $_POST['profile_experience_salary'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_experience_salary'] ) ) : '',
			'benefits'       => isset( $_POST['profile_experience_benefits'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_experience_benefits'] ) ) : '',
			'reason_leaving' => isset( $_POST['profile_experience_reason_leaving'] ) ? tasheel_hr_sanitize_profile_textarea( wp_unslash( $_POST['profile_experience_reason_leaving'] ) ) : '',
			'current_job'    => ! empty( $_POST['profile_experience_current_job'] ) ? '1' : '',
		);
	}
	if ( ! empty( $exp ) ) {
		$data['profile_experience'] = wp_json_encode( $exp, JSON_UNESCAPED_UNICODE );
	}
	}
	$lic = array();
	if ( ! empty( $_POST['profile_license_name'] ) || ! empty( $_POST['profile_license_job_title'] ) ) {
		$lic[] = array(
			'name'       => isset( $_POST['profile_license_name'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_license_name'] ) ) : '',
			'job_title'  => isset( $_POST['profile_license_job_title'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_license_job_title'] ) ) : '',
			'issue_date' => isset( $_POST['profile_license_issue_date'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_license_issue_date'] ) ) : '',
			'expiry'     => isset( $_POST['profile_license_expiry'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_license_expiry'] ) ) : '',
			'status'     => isset( $_POST['profile_license_status'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_license_status'] ) ) : '',
			'title'      => isset( $_POST['profile_license_title'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_license_title'] ) ) : '',
		);
	}
	if ( ! empty( $lic ) ) {
		$data['profile_licenses'] = wp_json_encode( $lic, JSON_UNESCAPED_UNICODE );
	}
	$proj = array();
	$proj_post = isset( $_POST['profile_recent_projects'] ) && is_array( $_POST['profile_recent_projects'] ) ? wp_unslash( $_POST['profile_recent_projects'] ) : array();
	if ( ! empty( $proj_post ) ) {
		foreach ( array_slice( $proj_post, 0, 3 ) as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$company = isset( $row['company'] ) ? sanitize_text_field( $row['company'] ) : '';
			$client = isset( $row['client'] ) ? sanitize_text_field( $row['client'] ) : '';
			if ( $company || $client ) {
				$proj[] = array(
					'company'  => $company,
					'client'   => $client,
					'period'   => isset( $row['period'] ) ? sanitize_text_field( $row['period'] ) : '',
					'position' => isset( $row['position'] ) ? sanitize_text_field( $row['position'] ) : '',
					'duties'   => isset( $row['duties'] ) ? tasheel_hr_sanitize_profile_textarea( $row['duties'] ) : '',
				);
			}
		}
	}
	if ( empty( $proj ) && ( ! empty( $_POST['profile_project_company'] ) || ! empty( $_POST['profile_project_client'] ) ) ) {
		$proj[] = array(
			'company'  => isset( $_POST['profile_project_company'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_project_company'] ) ) : '',
			'client'   => isset( $_POST['profile_project_client'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_project_client'] ) ) : '',
			'period'   => isset( $_POST['profile_project_period'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_project_period'] ) ) : '',
			'position' => isset( $_POST['profile_project_position'] ) ? sanitize_text_field( wp_unslash( $_POST['profile_project_position'] ) ) : '',
			'duties'   => isset( $_POST['profile_project_duties'] ) ? tasheel_hr_sanitize_profile_textarea( wp_unslash( $_POST['profile_project_duties'] ) ) : '',
		);
	}
	if ( ! empty( $proj ) ) {
		$data['profile_recent_projects'] = wp_json_encode( $proj, JSON_UNESCAPED_UNICODE );
	}
	// Clear conditional employment fields when answer is No.
	if ( isset( $data['profile_currently_employed'] ) && $data['profile_currently_employed'] === 'no' ) {
		$data['profile_employee_id']        = '';
		$data['profile_current_project']    = '';
		$data['profile_current_department'] = '';
	}
	if ( isset( $data['profile_previously_worked'] ) && $data['profile_previously_worked'] === 'no' ) {
		$data['profile_previous_duration']   = '';
		$data['profile_last_project']        = '';
		$data['profile_previous_department'] = '';
	}
	return $data;
}

/**
 * Handle Save Profile POST on Create Profile page. Saves to user meta and redirects to My Profile.
 * Runs on init (early) so it processes before template load - avoids page_id/queried_object issues.
 * Skips when the request is our AJAX save (admin-ajax.php + action=tasheel_hr_save_profile_ajax) so the AJAX handler returns JSON instead of redirecting.
 */
function tasheel_hr_handle_save_profile_post() {
	if ( $_SERVER['REQUEST_METHOD'] !== 'POST' || ! isset( $_POST['tasheel_save_profile'] ) ) {
		return;
	}
	// AJAX save must return JSON; do not run redirect logic here.
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && ! empty( $_POST['action'] ) && $_POST['action'] === 'tasheel_hr_save_profile_ajax' ) {
		return;
	}
	$err_key = 'tasheel_profile_save_err_' . get_current_user_id();
	if ( ! is_user_logged_in() ) {
		set_transient( $err_key, 'not_logged_in', 30 );
		$intended = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : home_url( '/create-profile/' );
		wp_safe_redirect( add_query_arg( array( 'redirect_to' => rawurlencode( $intended ), 'open_login' => '1' ), home_url( '/' ) ) );
		exit;
	}
	if ( empty( $_POST['tasheel_save_profile_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tasheel_save_profile_nonce'] ) ), 'tasheel_save_profile' ) ) {
		set_transient( $err_key, 'invalid_nonce', 30 );
		wp_safe_redirect( add_query_arg( 'profile_error', '1', wp_get_referer() ?: ( function_exists( 'tasheel_hr_create_profile_url' ) ? tasheel_hr_create_profile_url() : home_url( '/create-profile/' ) ) ) );
		exit;
	}
	delete_transient( $err_key );
	$user_id = get_current_user_id();
	$data    = tasheel_hr_build_profile_data_from_request();
	// When no job context (normal registration), require all mandatory fields (career). When applying to a job, require by job type.
	$apply_to     = isset( $_POST['apply_to'] ) ? (int) $_POST['apply_to'] : 0;
	$raw_slug     = $apply_to && function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $apply_to ) : '';
	$job_type_slug = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $raw_slug ) : 'career';
	$merged = array_merge( tasheel_hr_get_user_profile( $user_id ), $data );
	$missing = tasheel_hr_profile_missing_required_from_data( $merged, $job_type_slug, $user_id );
	$photo_err = function_exists( 'tasheel_hr_validate_profile_photo_upload' ) ? tasheel_hr_validate_profile_photo_upload() : '';
	if ( $photo_err !== '' ) {
		if ( ! in_array( 'profile_photo', $missing, true ) ) {
			$missing[] = 'profile_photo';
		}
	}
	// File upload validation (set during build when invalid file skipped).
	$file_upload_errors = function_exists( 'tasheel_hr_get_profile_file_validation_errors' ) ? tasheel_hr_get_profile_file_validation_errors() : array();
	foreach ( $file_upload_errors as $fk => $msg ) {
		if ( ! in_array( $fk, $missing, true ) ) {
			$missing[] = $fk;
		}
	}
	// Format validation (letters only for names, phone length, numbers, etc.).
	$format_errors = function_exists( 'tasheel_hr_profile_format_validation' ) ? tasheel_hr_profile_format_validation( $merged ) : array();
	foreach ( $format_errors as $fk => $msg ) {
		if ( ! in_array( $fk, $missing, true ) ) {
			$missing[] = $fk;
		}
	}
	if ( ! empty( $missing ) ) {
		$required_msg = __( 'is required.', 'tasheel' );
		$field_errors = array();
		foreach ( $missing as $mk ) {
			if ( isset( $file_upload_errors[ $mk ] ) ) {
				$field_errors[ $mk ] = $file_upload_errors[ $mk ];
			} elseif ( isset( $format_errors[ $mk ] ) ) {
				$field_errors[ $mk ] = $format_errors[ $mk ];
			} elseif ( $mk === 'profile_photo' && $photo_err !== '' ) {
				$field_errors[ $mk ] = $photo_err;
			} else {
				$field_errors[ $mk ] = ( function_exists( 'tasheel_hr_get_field_error_message' )
					? tasheel_hr_get_field_error_message( $mk, isset( $merged[ $mk ] ) ? $merged[ $mk ] : '', $required_msg )
					: ( ( function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( $mk ) : $mk ) . ' ' . $required_msg ) );
			}
		}
		// Preserve existing profile and previous failed-submit data so file fields (photo, resume, portfolio)
		// from an earlier attempt are not lost when user only adds e.g. Saudi Council and saves again.
		$existing_profile = tasheel_hr_get_user_profile( $user_id );
		$prev_missing     = get_transient( 'tasheel_hr_profile_save_missing_' . $user_id );
		$prev_submitted   = ( is_array( $prev_missing ) && ! empty( $prev_missing['submitted'] ) ) ? $prev_missing['submitted'] : array();
		$submitted        = array_merge( array(), $existing_profile, $prev_submitted, $data );
		set_transient( 'tasheel_hr_profile_save_missing_' . $user_id, array(
			'missing'       => $missing,
			'field_errors'  => $field_errors,
			'submitted'     => $submitted,
			'apply_to'      => $apply_to,
		), 120 );
		$create_url = function_exists( 'tasheel_hr_create_profile_url' ) ? tasheel_hr_create_profile_url( $apply_to ) : home_url( '/create-profile/' );
		wp_safe_redirect( add_query_arg( 'profile_error', 'missing', $create_url ) );
		exit;
	}
	tasheel_hr_save_user_profile( $user_id, $data );
	$my_profile_url = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url( $apply_to ) : home_url( '/my-profile/' );
	wp_safe_redirect( add_query_arg( 'profile_saved', '1', $my_profile_url ) );
	exit;
}
add_action( 'init', 'tasheel_hr_handle_save_profile_post', 1 );

/**
 * AJAX save profile: same validation and save as POST handler, returns JSON so page does not reload (uploads preserved).
 */
function tasheel_hr_save_profile_ajax() {
	// Prevent any stray output (notices/warnings) from breaking JSON response.
	if ( ! headers_sent() ) {
		@ob_start();
	}
	$user_id = get_current_user_id();
	if ( ! $user_id ) {
		if ( function_exists( 'ob_get_level' ) && ob_get_level() ) {
			@ob_end_clean();
		}
		wp_send_json_error( array( 'code' => 'not_logged_in', 'message' => __( 'Please log in to save your profile.', 'tasheel' ) ) );
	}
	if ( empty( $_POST['tasheel_save_profile_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tasheel_save_profile_nonce'] ) ), 'tasheel_save_profile' ) ) {
		if ( function_exists( 'ob_get_level' ) && ob_get_level() ) {
			@ob_end_clean();
		}
		wp_send_json_error( array( 'code' => 'invalid_nonce', 'message' => __( 'Security check failed. Please refresh and try again.', 'tasheel' ) ) );
	}
	$data = tasheel_hr_build_profile_data_from_request();
	$apply_to     = isset( $_POST['apply_to'] ) ? (int) $_POST['apply_to'] : 0;
	$raw_slug     = $apply_to && function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $apply_to ) : '';
	$job_type_slug = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $raw_slug ) : 'career';
	$merged = array_merge( tasheel_hr_get_user_profile( $user_id ), $data );
	$missing = tasheel_hr_profile_missing_required_from_data( $merged, $job_type_slug, $user_id );
	$photo_err = function_exists( 'tasheel_hr_validate_profile_photo_upload' ) ? tasheel_hr_validate_profile_photo_upload() : '';
	if ( $photo_err !== '' ) {
		if ( ! in_array( 'profile_photo', $missing, true ) ) {
			$missing[] = 'profile_photo';
		}
	}
	$file_upload_errors = function_exists( 'tasheel_hr_get_profile_file_validation_errors' ) ? tasheel_hr_get_profile_file_validation_errors() : array();
	foreach ( $file_upload_errors as $fk => $msg ) {
		if ( ! in_array( $fk, $missing, true ) ) {
			$missing[] = $fk;
		}
	}
	$format_errors = function_exists( 'tasheel_hr_profile_format_validation' ) ? tasheel_hr_profile_format_validation( $merged ) : array();
	foreach ( $format_errors as $fk => $msg ) {
		if ( ! in_array( $fk, $missing, true ) ) {
			$missing[] = $fk;
		}
	}
	if ( ! empty( $missing ) ) {
		$required_msg = __( 'is required.', 'tasheel' );
		$field_errors = array();
		$missing_labels = array();
		foreach ( $missing as $mk ) {
			$label = function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( $mk ) : $mk;
			if ( isset( $file_upload_errors[ $mk ] ) ) {
				$field_errors[ $mk ] = $file_upload_errors[ $mk ];
			} elseif ( isset( $format_errors[ $mk ] ) ) {
				$field_errors[ $mk ] = $format_errors[ $mk ];
			} elseif ( $mk === 'profile_photo' && $photo_err !== '' ) {
				$field_errors[ $mk ] = $photo_err;
			} else {
				$field_errors[ $mk ] = ( function_exists( 'tasheel_hr_get_field_error_message' )
					? tasheel_hr_get_field_error_message( $mk, isset( $merged[ $mk ] ) ? $merged[ $mk ] : '', $required_msg )
					: ( $label . ' ' . $required_msg ) );
			}
			$missing_labels[ $mk ] = $label;
		}
		if ( function_exists( 'ob_get_level' ) && ob_get_level() ) {
			@ob_end_clean();
		}
		wp_send_json_error( array(
			'code'           => 'missing',
			'missing'        => $missing,
			'field_errors'   => $field_errors,
			'missing_labels' => $missing_labels,
		) );
	}
	tasheel_hr_save_user_profile( $user_id, $data );
	$my_profile_url = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url( $apply_to ) : home_url( '/my-profile/' );
	if ( function_exists( 'ob_get_level' ) && ob_get_level() ) {
		@ob_end_clean();
	}
	wp_send_json_success( array( 'redirect' => add_query_arg( 'profile_saved', '1', $my_profile_url ) ) );
}
add_action( 'wp_ajax_tasheel_hr_save_profile_ajax', 'tasheel_hr_save_profile_ajax' );
add_action( 'wp_ajax_nopriv_tasheel_hr_save_profile_ajax', 'tasheel_hr_save_profile_ajax' );

/**
 * Redirect to our create-profile page after registration when redirect_to points there.
 *
 * @param string          $redirect_to Default redirect URL from WordPress.
 * @param int|WP_Error    $errors      User ID on success, or WP_Error on failure.
 * @return string
 */
function tasheel_hr_registration_redirect( $redirect_to, $errors ) {
	if ( is_wp_error( $errors ) ) {
		return $redirect_to;
	}
	$user_id = is_numeric( $errors ) ? (int) $errors : 0;

	// 1. Check transient (set in user_register) - most reliable.
	if ( $user_id ) {
		$stored = get_transient( 'tasheel_registration_redirect_' . $user_id );
		if ( $stored ) {
			delete_transient( 'tasheel_registration_redirect_' . $user_id );
			return $stored;
		}
	}

	// 2. Check $_REQUEST redirect_to from form POST.
	$requested = isset( $_REQUEST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ) : '';
	if ( $requested && ( strpos( $requested, 'create-profile' ) !== false || strpos( $requested, 'apply_to=' ) !== false || strpos( $requested, '/apply/' ) !== false ) ) {
		return $requested;
	}

	// 3. Check if default redirect is login page and we have create-profile intent.
	if ( $requested && strpos( $redirect_to, 'wp-login' ) !== false && strpos( $requested, 'create-profile' ) !== false ) {
		return $requested;
	}

	return $redirect_to;
}

add_filter( 'registration_redirect', 'tasheel_hr_registration_redirect', 5, 2 );

/**
 * Show applicant profile data in WordPress user edit screen (backend).
 * Only shown for users with the applicant role. Section is moved under the permalink via JS.
 */
function tasheel_hr_show_user_profile_backend( $user ) {
	if ( ! $user || ! isset( $user->ID ) ) {
		return;
	}
	$user_obj = get_userdata( $user->ID );
	$applicant_role = defined( 'TASHEEL_HR_APPLICANT_ROLE' ) ? TASHEEL_HR_APPLICANT_ROLE : 'applicant';
	if ( ! $user_obj || ! in_array( $applicant_role, (array) $user_obj->roles, true ) ) {
		return;
	}
	$profile = tasheel_hr_get_user_profile( $user->ID );
	$labels = tasheel_hr_profile_meta_labels();
	$skip = array( 'profile_education', 'profile_experience', 'profile_has_experience', 'profile_licenses', 'profile_recent_projects', 'profile_saudi_council_thumb', 'profile_currently_employed', 'profile_employee_id', 'profile_current_project', 'profile_current_department', 'profile_previously_worked', 'profile_previous_duration', 'profile_last_project', 'profile_previous_department' );
	$profile_photo = isset( $profile['profile_photo'] ) ? $profile['profile_photo'] : '';
	$profile_notes = get_user_meta( $user->ID, 'tasheel_hr_profile_notes', true );
	wp_nonce_field( 'tasheel_hr_save_profile_notes', 'tasheel_hr_profile_notes_nonce' );
	?>
	<div id="tasheel-applicant-profile-careers" style="scroll-margin-top: 32px;">
	<h3><?php esc_html_e( 'Applicant Profile (Careers)', 'tasheel' ); ?></h3>
	<p class="description" style="margin-bottom: 12px;"><?php esc_html_e( 'Shown when editing this user (Users → All Users → Edit). All HR admins with access see and edit the same notes.', 'tasheel' ); ?></p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="tasheel_hr_profile_notes"><?php esc_html_e( 'General notes (HR)', 'tasheel' ); ?></label></th>
			<td>
				<textarea name="tasheel_hr_profile_notes" id="tasheel_hr_profile_notes" class="large-text" rows="4" placeholder="<?php esc_attr_e( 'Add notes about this person…', 'tasheel' ); ?>"><?php echo esc_textarea( $profile_notes ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Notes about this person (across all applications). Not visible to the applicant. All admins see the same text here. For notes about a specific application, use Internal notes on that application\'s edit screen.', 'tasheel' ); ?></p>
			</td>
		</tr>
	</table>
	<?php if ( ! empty( $profile_photo ) ) : ?>
	<div style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 6px; display: inline-block;">
		<p style="margin: 0 0 10px 0; font-weight: 600;"><?php esc_html_e( 'Profile Photo', 'tasheel' ); ?></p>
		<a href="<?php echo esc_url( $profile_photo ); ?>" target="_blank" rel="noopener">
			<img src="<?php echo esc_url( $profile_photo ); ?>" alt="<?php esc_attr_e( 'Profile Photo', 'tasheel' ); ?>" style="max-width: 150px; height: auto; border-radius: 6px; border: 1px solid #ddd; display: block;">
		</a>
		<p style="margin: 8px 0 0 0; font-size: 12px;">
			<a href="<?php echo esc_url( $profile_photo ); ?>" target="_blank" rel="noopener"><?php echo esc_html( basename( wp_parse_url( $profile_photo, PHP_URL_PATH ) ) ); ?></a>
		</p>
	</div>
	<?php endif; ?>
	<table class="form-table">
		<?php foreach ( tasheel_hr_profile_meta_keys() as $key ) :
			if ( in_array( $key, $skip, true ) ) {
				continue;
			}
			$val = isset( $profile[ $key ] ) ? $profile[ $key ] : '';
			if ( empty( $val ) ) {
				continue;
			}
			$label = isset( $labels[ $key ] ) ? $labels[ $key ] : $key;
			$display = is_array( $val ) ? wp_json_encode( $val ) : esc_html( $val );
			if ( $key === 'profile_title' && function_exists( 'tasheel_hr_title_display_label' ) ) {
				$display = esc_html( tasheel_hr_title_display_label( $val ) );
			}
			if ( $key === 'profile_gender' && function_exists( 'tasheel_hr_gender_display_label' ) ) {
				$display = esc_html( tasheel_hr_gender_display_label( $val ) );
			}
			if ( $key === 'profile_marital_status' && function_exists( 'tasheel_hr_marital_status_label' ) ) {
				$display = esc_html( tasheel_hr_marital_status_label( $val ) );
			}
			if ( $key === 'profile_nationality' || $key === 'profile_country' ) {
				$display = esc_html( tasheel_hr_get_country_name( $val ) );
			}
			if ( $key === 'profile_national_status' ) {
				$display = esc_html( ucfirst( $val ) );
			}
			if ( $key === 'profile_specialization' ) {
				$display = esc_html( tasheel_hr_specialization_label( $val ) );
			}
			$file_keys = array( 'profile_resume', 'profile_portfolio', 'profile_saudi_council', 'profile_photo' );
			if ( filter_var( $val, FILTER_VALIDATE_URL ) ) {
				if ( in_array( $key, $file_keys, true ) ) {
					$filename = basename( wp_parse_url( $val, PHP_URL_PATH ) );
					// Skip profile_photo in table (shown as image above).
					if ( $key === 'profile_photo' ) {
						continue;
					}
					$display = '<a href="' . esc_url( $val ) . '" target="_blank" rel="noopener">' . esc_html( $filename ?: $val ) . '</a>';
				} else {
					$display = '<a href="' . esc_url( $val ) . '" target="_blank" rel="noopener">' . esc_html( $val ) . '</a>';
				}
			}
			?>
			<tr>
				<th><label><?php echo esc_html( $label ); ?></label></th>
				<td><?php echo $display; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php
	// Employment History at Saud Consult (grouped for clarity) – inside same wrapper so it moves to top with rest of career section.
	$curr_emp = isset( $profile['profile_currently_employed'] ) ? $profile['profile_currently_employed'] : '';
	$prev_work = isset( $profile['profile_previously_worked'] ) ? $profile['profile_previously_worked'] : '';
	if ( ! empty( $curr_emp ) || ! empty( $prev_work ) ) :
	?>
	<h4 style="margin-top: 24px;"><?php esc_html_e( 'Employment History at Saud Consult', 'tasheel' ); ?></h4>
	<table class="form-table">
		<tr>
			<th style="vertical-align: top; padding-top: 16px;"><label><?php esc_html_e( 'Currently employed at Saud Consult?', 'tasheel' ); ?></label></th>
			<td>
				<strong><?php echo esc_html( ucfirst( $curr_emp ) ); ?></strong>
				<?php if ( $curr_emp === 'yes' ) : ?>
				<div style="margin-top: 12px; margin-left: 20px; padding-left: 16px; border-left: 3px solid #0D6A37; color: #555;">
					<?php if ( ! empty( $profile['profile_employee_id'] ) ) : ?><p style="margin: 4px 0;"><strong><?php esc_html_e( 'Employee ID:', 'tasheel' ); ?></strong> <?php echo esc_html( $profile['profile_employee_id'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $profile['profile_current_project'] ) ) : ?><p style="margin: 4px 0;"><strong><?php esc_html_e( 'Current Project:', 'tasheel' ); ?></strong> <?php echo esc_html( $profile['profile_current_project'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $profile['profile_current_department'] ) ) : ?><p style="margin: 4px 0;"><strong><?php esc_html_e( 'Current Department:', 'tasheel' ); ?></strong> <?php echo esc_html( function_exists( 'tasheel_hr_department_display_label' ) ? tasheel_hr_department_display_label( $profile['profile_current_department'] ) : $profile['profile_current_department'] ); ?></p><?php endif; ?>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th style="vertical-align: top; padding-top: 16px;"><label><?php esc_html_e( 'Previously worked at Saud Consult?', 'tasheel' ); ?></label></th>
			<td>
				<strong><?php echo esc_html( ucfirst( $prev_work ) ); ?></strong>
				<?php if ( $prev_work === 'yes' ) : ?>
				<div style="margin-top: 12px; margin-left: 20px; padding-left: 16px; border-left: 3px solid #0D6A37; color: #555;">
					<?php if ( ! empty( $profile['profile_previous_duration'] ) ) : ?><p style="margin: 4px 0;"><strong><?php esc_html_e( 'Duration:', 'tasheel' ); ?></strong> <?php echo esc_html( $profile['profile_previous_duration'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $profile['profile_last_project'] ) ) : ?><p style="margin: 4px 0;"><strong><?php esc_html_e( 'Last Project:', 'tasheel' ); ?></strong> <?php echo esc_html( $profile['profile_last_project'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $profile['profile_previous_department'] ) ) : ?><p style="margin: 4px 0;"><strong><?php esc_html_e( 'Previous Department:', 'tasheel' ); ?></strong> <?php echo esc_html( function_exists( 'tasheel_hr_department_display_label' ) ? tasheel_hr_department_display_label( $profile['profile_previous_department'] ) : $profile['profile_previous_department'] ); ?></p><?php endif; ?>
				</div>
				<?php endif; ?>
			</td>
		</tr>
	</table>
	<?php endif; ?>
	<?php
	// Education, Experience, Recent Projects (from JSON).
	$edu = isset( $profile['profile_education'] ) ? $profile['profile_education'] : '';
	$edu_list = is_string( $edu ) ? json_decode( $edu, true ) : ( is_array( $edu ) ? $edu : array() );
	$exp = isset( $profile['profile_experience'] ) ? $profile['profile_experience'] : '';
	$exp_list = is_string( $exp ) ? json_decode( $exp, true ) : ( is_array( $exp ) ? $exp : array() );
	$proj = isset( $profile['profile_recent_projects'] ) ? $profile['profile_recent_projects'] : '';
	$proj_list = is_string( $proj ) ? json_decode( $proj, true ) : ( is_array( $proj ) ? $proj : array() );
	$edu_list = tasheel_hr_fix_profile_json_strings( $edu_list );
	$exp_list = tasheel_hr_fix_profile_json_strings( $exp_list );
	$proj_list = tasheel_hr_fix_profile_json_strings( $proj_list );
	if ( ! empty( $edu_list ) || ! empty( $exp_list ) || ! empty( $proj_list ) ) :
	?>
	<h4 style="margin-top: 24px;"><?php esc_html_e( 'Education, Experience & Projects', 'tasheel' ); ?></h4>
	<table class="form-table">
		<?php if ( ! empty( $edu_list ) ) : ?>
		<tr>
			<th><label><?php esc_html_e( 'Education', 'tasheel' ); ?></label></th>
			<td>
				<?php foreach ( $edu_list as $i => $item ) : $item = is_array( $item ) ? $item : array(); ?>
				<div style="margin-bottom: 12px; padding: 12px; background: #f9f9f9; border-radius: 4px; border-left: 3px solid #0D6A37;">
					<?php
					$deg = isset( $item['degree'] ) ? $item['degree'] : '';
					$maj = isset( $item['major'] ) ? $item['major'] : '';
					$deg_display = $deg && function_exists( 'tasheel_hr_education_degree_label' ) ? tasheel_hr_education_degree_label( $deg ) : $deg;
					$maj_display = $maj && function_exists( 'tasheel_hr_education_major_label' ) ? tasheel_hr_education_major_label( $maj ) : $maj;
					?>
					<strong><?php echo esc_html( trim( $deg_display . ' ' . $maj_display ) ); ?></strong>
					<?php if ( ! empty( $item['under_process'] ) ) : ?><span style="color:#888; font-size:12px;"> (<?php esc_html_e( 'Under Process', 'tasheel' ); ?>)</span><?php endif; ?>
					<br>
					<?php if ( ! empty( $item['institute'] ) ) : ?><?php echo esc_html( $item['institute'] ); ?><br><?php endif; ?>
					<?php if ( ! empty( $item['start_date'] ) || ! empty( $item['end_date'] ) ) : ?>
						<small><?php esc_html_e( 'Dates:', 'tasheel' ); ?> <?php echo esc_html( ( isset( $item['start_date'] ) ? $item['start_date'] : '' ) . ' - ' . ( isset( $item['end_date'] ) ? $item['end_date'] : '' ) ); ?></small><br>
					<?php endif; ?>
					<?php if ( ! empty( $item['city'] ) || ! empty( $item['country'] ) ) : ?>
						<small><?php echo esc_html( ( isset( $item['city'] ) ? $item['city'] : '' ) . ( ! empty( $item['city'] ) && ! empty( $item['country'] ) ? ', ' : '' ) . ( isset( $item['country'] ) ? tasheel_hr_get_country_name( $item['country'] ) : '' ) ); ?></small><br>
					<?php endif; ?>
					<?php if ( ! empty( $item['gpa'] ) ) : ?><small><?php esc_html_e( 'GPA:', 'tasheel' ); ?> <?php echo esc_html( $item['gpa'] ); ?></small><?php endif; ?>
					<?php if ( ! empty( $item['avg_grade'] ) ) : ?><small><?php esc_html_e( 'Avg Grade:', 'tasheel' ); ?> <?php echo esc_html( $item['avg_grade'] ); ?></small><?php endif; ?>
					<?php if ( ! empty( $item['mode'] ) ) : ?><small> | <?php esc_html_e( 'Mode:', 'tasheel' ); ?> <?php echo esc_html( function_exists( 'tasheel_hr_education_mode_label' ) ? tasheel_hr_education_mode_label( $item['mode'] ) : $item['mode'] ); ?></small><?php endif; ?>
				</div>
				<?php endforeach; ?>
			</td>
		</tr>
		<?php endif; ?>
		<?php if ( ! empty( $exp_list ) ) : ?>
		<tr>
			<th><label><?php esc_html_e( 'Experience', 'tasheel' ); ?></label></th>
			<td>
				<?php foreach ( $exp_list as $item ) : $item = is_array( $item ) ? $item : array(); ?>
				<div style="margin-bottom: 12px; padding: 12px; background: #f9f9f9; border-radius: 4px; border-left: 3px solid #0D6A37;">
					<strong><?php echo esc_html( isset( $item['job_title'] ) ? $item['job_title'] : '' ); ?></strong> <?php echo esc_html( isset( $item['employer'] ) ? ' @ ' . $item['employer'] : '' ); ?>
					<?php if ( ! empty( $item['current_job'] ) ) : ?><span style="color:#0a0; font-size:12px;"> (<?php esc_html_e( 'Current', 'tasheel' ); ?>)</span><?php endif; ?>
					<br>
					<?php if ( ! empty( $item['start_date'] ) || ! empty( $item['end_date'] ) ) : ?>
						<small><?php esc_html_e( 'Dates:', 'tasheel' ); ?> <?php echo esc_html( ( isset( $item['start_date'] ) ? $item['start_date'] : '' ) . ' - ' . ( isset( $item['end_date'] ) ? $item['end_date'] : '' ) ); ?></small><br>
					<?php endif; ?>
					<?php if ( ! empty( $item['country'] ) ) : ?><small><?php esc_html_e( 'Country:', 'tasheel' ); ?> <?php echo esc_html( tasheel_hr_get_country_name( $item['country'] ) ); ?></small><br><?php endif; ?>
					<?php if ( ! empty( $item['years'] ) ) : ?><small><?php esc_html_e( 'Years:', 'tasheel' ); ?> <?php echo esc_html( $item['years'] ); ?></small><?php endif; ?>
					<?php if ( ! empty( $item['salary'] ) ) : ?><small> | <?php esc_html_e( 'Salary:', 'tasheel' ); ?> <?php echo esc_html( $item['salary'] ); ?></small><?php endif; ?>
					<?php if ( ! empty( $item['benefits'] ) ) : ?><br><small><?php esc_html_e( 'Benefits:', 'tasheel' ); ?> <?php echo esc_html( $item['benefits'] ); ?></small><?php endif; ?>
					<?php if ( ! empty( $item['reason_leaving'] ) ) : ?><br><small><?php esc_html_e( 'Reason for leaving:', 'tasheel' ); ?> <?php echo esc_html( $item['reason_leaving'] ); ?></small><?php endif; ?>
				</div>
				<?php endforeach; ?>
			</td>
		</tr>
		<?php endif; ?>
		<?php if ( ! empty( $proj_list ) ) : ?>
		<tr>
			<th><label><?php esc_html_e( 'Recent Projects', 'tasheel' ); ?></label></th>
			<td>
				<?php foreach ( $proj_list as $pr ) : $pr = is_array( $pr ) ? $pr : array(); ?>
				<div style="margin-bottom: 12px; padding: 12px; background: #f9f9f9; border-radius: 4px; border-left: 3px solid #0D6A37;">
					<strong><?php echo esc_html( isset( $pr['company'] ) ? $pr['company'] : '' ); ?></strong> <?php echo esc_html( isset( $pr['client'] ) ? ' – ' . $pr['client'] : '' ); ?><br>
					<?php if ( ! empty( $pr['position'] ) || ! empty( $pr['period'] ) ) : ?>
						<?php
						$pos = isset( $pr['position'] ) ? $pr['position'] : '';
						$per = isset( $pr['period'] ) ? $pr['period'] : '';
						$pos_display = $pos && function_exists( 'tasheel_hr_project_position_label' ) ? tasheel_hr_project_position_label( $pos ) : $pos;
						$per_display = $per && function_exists( 'tasheel_hr_project_period_label' ) ? tasheel_hr_project_period_label( $per ) : $per;
						?>
						<small><?php echo esc_html( $pos_display . ( $pos_display && $per_display ? ' | ' : '' ) . $per_display ); ?></small><br>
					<?php endif; ?>
					<?php if ( ! empty( $pr['duties'] ) ) : ?><small><?php esc_html_e( 'Duties:', 'tasheel' ); ?> <?php echo esc_html( $pr['duties'] ); ?></small><?php endif; ?>
				</div>
				<?php endforeach; ?>
			</td>
		</tr>
		<?php endif; ?>
	</table>
	<?php endif; ?>
	<?php
	?>
	</div>
	<?php
}

/**
 * Save general profile notes (user meta) when profile is updated in admin.
 *
 * @param int $user_id User ID.
 */
function tasheel_hr_save_profile_notes( $user_id ) {
	if ( ! isset( $_POST['tasheel_hr_profile_notes_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tasheel_hr_profile_notes_nonce'] ) ), 'tasheel_hr_save_profile_notes' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return;
	}
	$notes = isset( $_POST['tasheel_hr_profile_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['tasheel_hr_profile_notes'] ) ) : '';
	update_user_meta( $user_id, 'tasheel_hr_profile_notes', $notes );
}

add_action( 'show_user_profile', 'tasheel_hr_show_user_profile_backend' );
add_action( 'edit_user_profile', 'tasheel_hr_show_user_profile_backend' );
add_action( 'personal_options_update', 'tasheel_hr_save_profile_notes' );
add_action( 'edit_user_profile_update', 'tasheel_hr_save_profile_notes' );

/**
 * Move Applicant Profile (Careers) to the very top of the user form so it appears above
 * "Personal Options", "Name", and all other core sections. Script runs in admin_footer.
 */
function tasheel_hr_user_edit_move_applicant_section_script() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || ( $screen->id !== 'user-edit' && $screen->id !== 'profile' ) ) {
		return;
	}
	?>
	<script>
	(function() {
		function moveApplicantSection() {
			var section = document.getElementById('tasheel-applicant-profile-careers');
			if (!section) return;
			var form = document.getElementById('your-profile');
			if (!form) form = document.querySelector('form[action*="user-edit.php"]');
			if (!form) form = document.querySelector('form[action*="profile.php"]');
			if (!form) return;
			var first = form.firstElementChild;
			form.insertBefore(section, first || null);
		}
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', moveApplicantSection);
		} else {
			moveApplicantSection();
		}
	})();
	</script>
	<?php
}

add_action( 'admin_footer', 'tasheel_hr_user_edit_move_applicant_section_script', 5 );

/**
 * Add "User note (HR)" column to Users list so main admin and HR admins can see applicant notes.
 */
function tasheel_hr_users_columns_user_note( $columns ) {
	$app_obj = get_post_type_object( 'job_application' );
	$cap     = ( $app_obj && isset( $app_obj->cap->edit_posts ) ) ? $app_obj->cap->edit_posts : 'edit_others_posts';
	if ( ! current_user_can( $cap ) ) {
		return $columns;
	}
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( $key === 'email' ) {
			$new['tasheel_hr_user_note']       = __( 'User note (HR)', 'tasheel' );
			$new['tasheel_hr_applications']    = __( 'Applications', 'tasheel' );
		}
	}
	if ( ! isset( $new['tasheel_hr_user_note'] ) ) {
		$new['tasheel_hr_user_note'] = __( 'User note (HR)', 'tasheel' );
	}
	if ( ! isset( $new['tasheel_hr_applications'] ) ) {
		$new['tasheel_hr_applications'] = __( 'Applications', 'tasheel' );
	}
	return $new;
}

/**
 * Output User note (HR) for each user in the Users list.
 *
 * @param string $value    Default column value.
 * @param string $column_name Column key.
 * @param int    $user_id  User ID.
 * @return string
 */
function tasheel_hr_users_custom_column_user_note( $value, $column_name, $user_id ) {
	if ( $column_name !== 'tasheel_hr_user_note' ) {
		return $value;
	}
	$app_obj = get_post_type_object( 'job_application' );
	$cap     = ( $app_obj && isset( $app_obj->cap->edit_posts ) ) ? $app_obj->cap->edit_posts : 'edit_others_posts';
	if ( ! current_user_can( $cap ) ) {
		return $value;
	}
	$note = get_user_meta( $user_id, 'tasheel_hr_profile_notes', true );
	if ( (string) $note === '' ) {
		return '—';
	}
	return '<span title="' . esc_attr( $note ) . '">' . esc_html( wp_trim_words( $note, 12 ) ) . '</span>';
}

/**
 * Output Applications count (total job applications) for each user in the Users list.
 * Only meaningful for applicant role; others show —.
 *
 * @param string $value       Default column value.
 * @param string $column_name Column key.
 * @param int    $user_id     User ID.
 * @return string
 */
function tasheel_hr_users_custom_column_applications( $value, $column_name, $user_id ) {
	if ( $column_name !== 'tasheel_hr_applications' ) {
		return $value;
	}
	$app_obj = get_post_type_object( 'job_application' );
	$cap     = ( $app_obj && isset( $app_obj->cap->edit_posts ) ) ? $app_obj->cap->edit_posts : 'edit_others_posts';
	if ( ! current_user_can( $cap ) ) {
		return $value;
	}
	global $wpdb;
	$count = (int) $wpdb->get_var( $wpdb->prepare(
		"SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'job_application' AND post_status IN ('publish','draft','pending','private') AND post_author = %d",
		$user_id
	) );
	if ( $count === 0 ) {
		return '—';
	}
	$url = admin_url( 'edit.php?post_type=job_application&author=' . $user_id );
	return '<a href="' . esc_url( $url ) . '" title="' . esc_attr__( 'View applications', 'tasheel' ) . '">' . $count . '</a>';
}

add_filter( 'manage_users_columns', 'tasheel_hr_users_columns_user_note', 10, 1 );
add_filter( 'manage_users_custom_column', 'tasheel_hr_users_custom_column_user_note', 10, 3 );
add_filter( 'manage_users_custom_column', 'tasheel_hr_users_custom_column_applications', 10, 3 );

/**
 * Build export row for one user: Applicant Profile (Careers) fields from user meta, same format as application export.
 * Returns only profile columns (same order as profile keys in tasheel_hr_users_export_profile_headers, excluding base columns).
 *
 * @param WP_User $user User object.
 * @return array Values in same order as profile keys in headers (profile_title, profile_first_name, ...).
 */
function tasheel_hr_users_export_profile_row( $user ) {
	$user_id = (int) $user->ID;
	$keys = function_exists( 'tasheel_hr_export_snapshot_keys_in_form_order' ) ? tasheel_hr_export_snapshot_keys_in_form_order() : array();
	$snapshot = array();
	foreach ( $keys as $key ) {
		if ( $key === 'start_date' || $key === 'duration' ) {
			$snapshot[ $key ] = '';
			continue;
		}
		$snapshot[ $key ] = get_user_meta( $user_id, $key, true );
	}
	$snapshot['profile_title']        = get_user_meta( $user_id, 'profile_title', true );
	$snapshot['profile_first_name']   = get_user_meta( $user_id, 'profile_first_name', true );
	$snapshot['profile_middle_name']  = get_user_meta( $user_id, 'profile_middle_name', true );
	$snapshot['profile_last_name']   = get_user_meta( $user_id, 'profile_last_name', true );
	$snapshot['profile_email']       = $user->user_email;

	$readable_complex = array( 'profile_education', 'profile_experience', 'profile_licenses', 'profile_recent_projects' );
	$base_keys = array( 'username', 'email', 'registered', 'user_note', 'applications', 'role' );
	$headers = tasheel_hr_users_export_profile_headers();
	$row = array();
	foreach ( array_keys( $headers ) as $key ) {
		if ( in_array( $key, $base_keys, true ) ) {
			continue;
		}
		$val = isset( $snapshot[ $key ] ) ? $snapshot[ $key ] : '';
		if ( in_array( $key, $readable_complex, true ) ) {
			if ( $key === 'profile_education' && function_exists( 'tasheel_hr_export_format_education' ) ) {
				$val = tasheel_hr_export_format_education( $val );
			} elseif ( $key === 'profile_experience' && function_exists( 'tasheel_hr_export_format_experience' ) ) {
				$val = tasheel_hr_export_format_experience( $val );
			} elseif ( $key === 'profile_licenses' && function_exists( 'tasheel_hr_export_format_licenses' ) ) {
				$val = tasheel_hr_export_format_licenses( $val );
			} elseif ( $key === 'profile_recent_projects' && function_exists( 'tasheel_hr_export_format_recent_projects' ) ) {
				$val = tasheel_hr_export_format_recent_projects( $val );
			}
		} elseif ( is_array( $val ) ) {
			if ( ( $key === 'profile_portfolio' || $key === 'profile_photo' || $key === 'profile_resume' || $key === 'profile_saudi_council' ) && ! empty( $val['url'] ) ) {
				$val = $val['url'];
			} else {
				$val = '';
			}
		}
		if ( ( $key === 'profile_nationality' || $key === 'profile_country' ) && function_exists( 'tasheel_hr_get_country_name' ) ) {
			$val = tasheel_hr_get_country_name( $val );
		}
		if ( $key === 'profile_specialization' && function_exists( 'tasheel_hr_specialization_label' ) ) {
			$val = tasheel_hr_specialization_label( $val );
		}
		if ( $key === 'profile_visa_status' && function_exists( 'tasheel_hr_visa_status_label' ) ) {
			$val = tasheel_hr_visa_status_label( $val );
		}
		if ( $key === 'profile_title' && function_exists( 'tasheel_hr_title_display_label' ) ) {
			$val = tasheel_hr_title_display_label( $val );
		}
		$row[] = (string) $val;
	}
	return $row;
}

/**
 * Headers for user export (Applicant Profile details). Same structure as application export for consistency.
 *
 * @return array Key => translated label (order: base columns then profile fields).
 */
function tasheel_hr_users_export_profile_headers() {
	$base = array(
		'username'     => __( 'Username', 'tasheel' ),
		'email'        => __( 'Email', 'tasheel' ),
		'registered'   => __( 'Registered', 'tasheel' ),
		'user_note'    => __( 'User note (HR)', 'tasheel' ),
		'applications' => __( 'Applications', 'tasheel' ),
		'role'         => __( 'Role', 'tasheel' ),
	);
	$labels = function_exists( 'tasheel_hr_profile_meta_labels' ) ? tasheel_hr_profile_meta_labels() : array();
	$labels['profile_title'] = __( 'Title', 'tasheel' );
	$profile_keys = array( 'profile_title', 'profile_first_name', 'profile_middle_name', 'profile_last_name' );
	if ( function_exists( 'tasheel_hr_export_snapshot_keys_in_form_order' ) ) {
		$snapshot = tasheel_hr_export_snapshot_keys_in_form_order();
		foreach ( $snapshot as $k ) {
			if ( $k !== 'start_date' && $k !== 'duration' && ! in_array( $k, $profile_keys, true ) ) {
				$profile_keys[] = $k;
			}
		}
	}
	$out = $base;
	foreach ( $profile_keys as $k ) {
		$out[ $k ] = isset( $labels[ $k ] ) ? $labels[ $k ] : $k;
	}
	return $out;
}

/**
 * Handle Users list export to CSV or Excel. Respects role filter and date range. Exports full Applicant Profile details.
 * Role-based: only users with list_users and edit_posts for job_application can export (Administrators and HR admins/recruiters).
 * Runs on load-users.php.
 */
function tasheel_hr_users_handle_export() {
	$export = isset( $_GET['tasheel_hr_users_export'] ) ? sanitize_text_field( wp_unslash( $_GET['tasheel_hr_users_export'] ) ) : '';
	if ( $export !== 'csv' && $export !== 'excel' ) {
		return;
	}
	if ( ! current_user_can( 'list_users' ) ) {
		wp_die( esc_html__( 'You do not have permission to export users.', 'tasheel' ), 403 );
	}
	$app_obj = get_post_type_object( 'job_application' );
	$cap     = ( $app_obj && isset( $app_obj->cap->edit_posts ) ) ? $app_obj->cap->edit_posts : 'edit_others_posts';
	if ( ! current_user_can( $cap ) ) {
		wp_die( esc_html__( 'You do not have permission to export user data.', 'tasheel' ), 403 );
	}

	$role = isset( $_GET['role'] ) ? sanitize_text_field( wp_unslash( $_GET['role'] ) ) : '';
	$date_from = isset( $_GET['users_export_date_from'] ) ? sanitize_text_field( wp_unslash( $_GET['users_export_date_from'] ) ) : '';
	$date_to   = isset( $_GET['users_export_date_to'] ) ? sanitize_text_field( wp_unslash( $_GET['users_export_date_to'] ) ) : '';

	$args = array(
		'orderby' => 'login',
		'order'   => 'ASC',
		'number'  => 0,
	);
	if ( $role !== '' ) {
		$args['role'] = $role;
	}
	if ( $date_from !== '' || $date_to !== '' ) {
		$args['date_query'] = array();
		if ( $date_from !== '' ) {
			$args['date_query'][] = array( 'after' => $date_from . ' 00:00:00', 'inclusive' => true );
		}
		if ( $date_to !== '' ) {
			$args['date_query'][] = array( 'before' => $date_to . ' 23:59:59', 'inclusive' => true );
		}
	}
	$user_query = new WP_User_Query( $args );
	$users = $user_query->get_results();

	$use_bom = ( $export === 'excel' );
	$suffix  = ( $role !== '' ) ? '-' . $role : '-all';
	$filename = 'users' . $suffix . '-' . gmdate( 'Y-m-d-His' ) . ( $export === 'excel' ? '.xls' : '.csv' );

	header( 'Content-Type: ' . ( $use_bom ? 'application/vnd.ms-excel' : 'text/csv' ) . '; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	if ( $use_bom ) {
		echo "\xEF\xBB\xBF";
	}

	$profile_headers = tasheel_hr_users_export_profile_headers();
	$cols = array_values( $profile_headers );
	echo tasheel_hr_users_export_csv_row( $cols, $use_bom );

	global $wpdb;
	foreach ( $users as $user ) {
		$note = get_user_meta( $user->ID, 'tasheel_hr_profile_notes', true );
		$note = (string) $note === '' ? '' : $note;
		$app_count = (int) $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'job_application' AND post_status IN ('publish','draft','pending','private') AND post_author = %d",
			$user->ID
		) );
		$roles = ! empty( $user->roles ) && is_array( $user->roles ) ? implode( ', ', $user->roles ) : '';
		$registered = $user->user_registered ? gmdate( 'Y-m-d H:i', strtotime( $user->user_registered ) ) : '';

		$base_row = array(
			$user->user_login,
			$user->user_email,
			$registered,
			$note,
			$app_count,
			$roles,
		);
		$profile_row = function_exists( 'tasheel_hr_users_export_profile_row' ) ? tasheel_hr_users_export_profile_row( $user ) : array();
		$row = array_merge( $base_row, $profile_row );
		echo tasheel_hr_users_export_csv_row( $row, $use_bom );
	}
	exit;
}

/**
 * Output a CSV row for users export (escape and quote for CSV/Excel).
 *
 * @param array $row   Values.
 * @param bool  $excel Use tab and UTF-8 BOM already sent.
 * @return string
 */
function tasheel_hr_users_export_csv_row( $row, $excel = false ) {
	$sep = $excel ? "\t" : ',';
	$out = array();
	foreach ( $row as $cell ) {
		$cell = (string) $cell;
		$cell = str_replace( array( "\r", "\n" ), array( ' ', ' ' ), $cell );
		if ( $excel ) {
			$out[] = '"' . str_replace( '"', '""', $cell ) . '"';
		} else {
			if ( strpos( $cell, $sep ) !== false || strpos( $cell, '"' ) !== false ) {
				$cell = '"' . str_replace( '"', '""', $cell ) . '"';
			}
			$out[] = $cell;
		}
	}
	return implode( $sep, $out ) . "\n";
}

add_action( 'load-users.php', 'tasheel_hr_users_handle_export', 5 );

/**
 * Add Export CSV / Export Excel and date range to the Users list (above the table).
 * Export respects current role filter and date range. Role-based: HR admins/recruiters with list_users and edit job_application can export.
 */
function tasheel_hr_users_extra_tablenav( $which ) {
	if ( $which !== 'top' ) {
		return;
	}
	$app_obj = get_post_type_object( 'job_application' );
	$cap     = ( $app_obj && isset( $app_obj->cap->edit_posts ) ) ? $app_obj->cap->edit_posts : 'edit_others_posts';
	if ( ! current_user_can( 'list_users' ) || ! current_user_can( $cap ) ) {
		return;
	}
	$role      = isset( $_GET['role'] ) ? sanitize_text_field( wp_unslash( $_GET['role'] ) ) : '';
	$date_from = isset( $_GET['users_export_date_from'] ) ? sanitize_text_field( wp_unslash( $_GET['users_export_date_from'] ) ) : '';
	$date_to   = isset( $_GET['users_export_date_to'] ) ? sanitize_text_field( wp_unslash( $_GET['users_export_date_to'] ) ) : '';
	?>
	<div class="alignleft actions" style="margin-right:8px;">
		<form method="get" action="<?php echo esc_url( admin_url( 'users.php' ) ); ?>" style="display:inline-flex; align-items:center; flex-wrap:wrap; gap:6px;">
			<?php if ( $role !== '' ) : ?>
				<input type="hidden" name="role" value="<?php echo esc_attr( $role ); ?>" />
			<?php endif; ?>
			<label for="users_export_date_from"><?php esc_html_e( 'From', 'tasheel' ); ?></label>
			<input type="date" name="users_export_date_from" id="users_export_date_from" value="<?php echo esc_attr( $date_from ); ?>" />
			<label for="users_export_date_to"><?php esc_html_e( 'To', 'tasheel' ); ?></label>
			<input type="date" name="users_export_date_to" id="users_export_date_to" value="<?php echo esc_attr( $date_to ); ?>" />
			<button type="submit" name="tasheel_hr_users_export" value="csv" class="button"><?php esc_html_e( 'Export CSV', 'tasheel' ); ?></button>
			<button type="submit" name="tasheel_hr_users_export" value="excel" class="button"><?php esc_html_e( 'Export Excel', 'tasheel' ); ?></button>
		</form>
	</div>
	<?php
}

add_action( 'manage_users_extra_tablenav', 'tasheel_hr_users_extra_tablenav', 10, 1 );
