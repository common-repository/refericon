<?php
/*
* Plugin name: Refericon
* Description: Refericon ułatwia rekomendowanie Twoich produktów przez zadowolonych klientów ich znajomym. Instalacja i ustawienie programu referencyjnego trwa niecałe 6 minut. Dzięki aplikacji zyskasz wiedzę o poleceniach swojego sklepu, dotrzesz do nowych klientów i nagrodzisz tych lojalnych.
* Version: 1.0
* http://beta.refericon.pl
* Author: Refericon
* Author URI: http://refericon.pl
* License: GNU GPL
*/

class Refericon {
	private $dir;
	private $url;

	function __construct()
	{
		$this->dir = __DIR__;
		$this->url = plugin_dir_url(__FILE__);
		add_action('admin_menu', array($this, 'menu'));
		add_action('wp_footer', array($this, 'showCode'));
	}

	function menu()
	{
		add_menu_page('Refericon', 'Refericon', 'manage_options', 'refericon', array($this, 'page'), $this->url.'/assets/ri-logo32.png');
	}

	function page()
	{
		$code = get_option('Refericon-code');

		if (isset($_POST['ricode']))
		{
			if (update_option('Refericon-code', htmlentities($_POST['ricode'])))
			{
				echo "<div class='notice notice-success updated'><p>Zapisano</p></div>";
			}else{
				echo "<div class='notice notice-warning error'><p>Wystąpił błąd</p></div>";
			}
		}
		?>
			<div class="wrap">
				<h2 style="text-align:center"><img style="display:inline;" src="<?php echo  $this->url.'/assets/ri-logo.png';?>"></h2>
				<form action="" method="POST">
					<p style="text-align:center;">
						<label for="ricode">
							Po ustawieniu swojego programu referencyjnego skopiuj wygenerowany kod JS i umieść go poniżej. Po zapisaniu aplikacja rozpocznie działania na Twoim sklepie. W każdej chwili możesz edytować kampanię tutaj: <a href="http://beta.refericon.pl/campaigns">http://beta.refericon.pl/campaigns</a> 
						</label>
						</p>
						<p>

						<textarea style="width:50%;display:block;margin:0 auto;min-height:100px;"  placeholder="Twój kod" name="ricode" required><?php echo stripcslashes($code);?></textarea>
					</p>
					<style>
					p.submit {text-align:center;}
					</style>
					<?php submit_button("Dodaj kod"); ?>
				</form>

			</div>
		<?php
	}

	function showCode()
	{
		echo html_entity_decode(stripslashes(get_option('Refericon-code')));
		
	}

}
$refericon = new Refericon();