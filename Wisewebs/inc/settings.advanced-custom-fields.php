<?php

// Set namespace
Namespace Wisewebs\Settings\AdvancedCustomFields;

// Import relevant namespaces
Use Wisewebs\Classes\Content;


/*----------  Set up options pages  ----------*/

if ( function_exists( 'acf_add_options_page' ) ) {

	// Generic options page
	$parent = acf_add_options_page(
		Array(
			'page_title' 	=> 'Inställningar',
			'menu_title'	=> 'Inställningar',
			'menu_slug' 	=> 'wisewebs-theme-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> true
		)
	);



	// Mobile menu
	acf_add_options_sub_page(
		Array(
			'page_title' 	=> 'Mobilmeny',
			'menu_title' 	=> 'Mobilmeny',
			'parent_slug' 	=> $parent[ 'menu_slug' ],
		)
	);



	// Shop pages
	acf_add_options_sub_page(
		Array(
			'page_title' 	=> 'Produktsidor och kategorisidor',
			'menu_title' 	=> 'Produktsidor &amp; kategorisidor',
			'parent_slug' 	=> $parent[ 'menu_slug' ],
		)
	);



	// Footer
	acf_add_options_sub_page(
		Array(
			'page_title' 	=> 'Sidfot',
			'menu_title' 	=> 'Sidfot',
			'parent_slug' 	=> $parent[ 'menu_slug' ],
		)
	);



	// Spare parts options page
	$parent = acf_add_options_page(
		Array(
			'page_title' 	=> 'Reservdelar',
			'menu_title'	=> 'Reservdelar',
			'menu_slug' 	=> 'wisewebs-spare-parts-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> true
		)
	);
}





/*----------  Add the Google Maps API key so we can maps in admin mode  ----------*/

add_action(
	'acf/init',
	'Wisewebs\\Classes\\Content\\GoogleMap::addAPIKeyToACF'
);






if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_5e5e7a0d879bd',
		'title' => 'Reservdelsinformation',
		'fields' => array(
			array(
				'key' => 'field_5e5e7a17399e7',
				'label' => 'Priser i PartStream',
				'name' => '',
				'type' => 'message',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => 'För reservdelar som visas i PartStream så sköts visning av priser via deras system. För att uppdatera priserna behöver man därför ladda upp prisfiler genom deras s.k. StreamsAdmin-system. Länk för att logga in i StreamsAdmin är: <a href="https://streamsadmin.arinet.com/Login" target="_blank">https://streamsadmin.arinet.com/Login</a>.',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			array(
				'key' => 'field_5e5e7b5b7c8b6',
				'label' => 'Priser i Husqvarna xEPC',
				'name' => '',
				'type' => 'message',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => 'För reservdelar som visas i Husqvarnas xEPC sköts priserna här i webbshoppen via WooCommerce. xEPC:n fungerar bara som en katalog och visar aldrig priserna, utan lämnar det ansvaret till webbshoppen. Priser sparas därför istället som varianter på en vanlig produkt ("Husqvarna reservdel").

				<div style="border-left: 3px solid #666; font-style: italic; background: #eee; margin: 0; padding: 1em;"><p style="margin-top: 0;"><strong style="color: tomato;"><em>OBS!</em></strong> Att spara alla delar i sitt egna system ställer krav på webbhotellet där sidan ligger. P.g.a. begränsningar hos One.com då xEPC implementerades kunde inte WooCommmerce inbyggda import-funktion användas (rättare sagt: den går bra till en början, men när man går över ett visst antal reservdelar så börjar importer avbrytas p.g.a. att de tar längre tid än vad webbhotellet tillåter och slutar förr eller senare importera överhuvudtaget).</p><p style="margin-bottom: 0;">Använd därför endast den här sidan för att redigera Husqvarna reservdelar. Eventuella ändringar för Husqvarna reservdelar som görs direkt via gränssnittet eller WooCommerce egna importfunktion kan komma att automatiskt skrivas över.</p></div>

				Reservdelslistan för xEPC har därför en egen specialhantering och uppdatering av priser går därför till så här:

				<ol>
					<li>Börja med att hämta aktuell prislista från Husqvarna.</li>
					<li>Ladda sen ner <a href="/wp-content/themes/Wisewebs/assets/excel/husqvarna-reservdelsimport.xlsx">Excel-filen för att uppdatera priser</a>.</li>
					<li>Öppna Excel-filen och gå till bladet <em>"Artikelnummerkonvertering"</em>. Artikelnumren i Husqvarna xEPC har lite annat format än i Husqvarnas prislistor och måste därför först justeras så de matchar. <ol>
							<li>Ta bort de tidigare artikelnumren.</li>
							<li>Kopiera artikelnumren från prislistan och klistra in i den blå kolumnen (<em>"Formaterat"</em>).</li>
							<li>Kopiera artikelnumren från den högra kolumnen (<em>"Anpassat för xEPC"</em>) till första kolumnen i första bladet (<em>"Reservdelslista"</em>).</li>
						</ol>
					</li>
					<li>Kopiera kolumnen <em>"Description"</em> från prislistan till andra kolumnen i bladet <em>"Reservdelslista"</em>.</li>
					<li>Gå till bladet <em>"Priskonvertering"</em>.<ol>
						<li>Ta bort de tidigare priserna.</li>
						<li>Kopiera artikelnumren från prislistan och klistra in i den blå kolumnen (<em>"Exkl. moms"</em>).</li>
						<li>Kopiera priserna från den högra kolumnen (<em>"Inkl. moms"</em>) till första kolumnen i första bladet (<em>"Reservdelslista"</em>).</li>
						</ol>
					</li>
					<li><em>"Spara som"</em> i Excel och välj filformatet CSV.</li>
					<li>Stäng filen, öppna den på nytt i Excel (d.v.s. den nya <em>".csv"</em>-filen), och spara igen. Detta gör att Excel tar bort tomma rader från filen (Excel lämnar av någon anledning kvar tomma rader just i <em>"Spara som"</em> skedet, vilket gör att importen tar längre tid).</li>
					<li>Ladda upp CSV-filen via formuläret nedan.</li>
				</ol>
				<form id="xepc-csv-import-form">
					<strong>Uppladdning av reservdelslista:</strong>
					<br>
					<input type="file" accept=".csv" name="xepc-csv-upload" id="xepc-csv-import-form__file-input">
					<br>
					<button type="button" id="xepc-csv-import-form__button" class="xepc-csv-import-form__button button button-primary button-large">' .
						'<span class="xepc-csv-import-form__button-ready-text">Ladda upp</span>' .
						'<span class="xepc-csv-import-form__button-preparing-text" style="display: none;">Förbereder...</span>' .
						'<span class="xepc-csv-import-form__button-processing-text" style="display: none;">Behandlar, det här kan ta ett tag...</span>' .
					'</button>
				</form>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'wisewebs-spare-parts-settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	));

endif;
