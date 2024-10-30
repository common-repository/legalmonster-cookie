<div class="legalmonster-plugin">
	<div class="wrap">
		<h2><?php echo $this->plugin->displayName; ?> &raquo; <?php esc_html_e( 'Settings', 'legalmonster' ); ?></h2>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<!-- Content -->

				<!-- Tab links -->
				<div class="tab">
					<button class="tablinks active" onclick="openTab(event, 'Signup')">Sign up</button>
					<button class="tablinks" onclick="openTab(event, 'Setup')">Setup</button>
				</div>

				<!-- Tab content -->
				<div id="post-body-content">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div id="Setup" class="tabcontent">
							<div class="postbox">
								<div class="inside">
									<h1>Choose the language of the widget</h1>
									<p>Legal Monster supports different languages and jurisdictions. See the full list <a href="https://docs.legalmonster.com/guides/cookie-widget/setup-widget-language#supported-languages" target="_blank">here</a></p>

									<p><strong>Choose language and jurisdictions</strong></p>
									<form action="admin.php?page=<?php echo esc_html($this->plugin->name); ?>" method="post">
										<select name="lm_locale" id="lm_locale" class="form-input">
											<?php echo isset( $this->settings['lm_locale'] ) ?>
											<option value="" selected="<?php esc_attr_e(isset( $this->settings['lm_locale']) ? 'false' : 'true'); ?>" disabled="disabled">Select cookie policy jurisdiction and language</option>
											<option value="da-dk" <?php esc_attr_e(($this->settings['lm_locale'] === "da-dk") ? 'selected' : ''); ?>>Denmark (Danish)</option>
											<option value="no-no" <?php esc_attr_e(($this->settings['lm_locale'] === "no-no") ? 'selected' : ''); ?>>Norway (Norwegian)</option>
											<option value="nb-no" <?php esc_attr_e(($this->settings['lm_locale'] === "nb-no") ? 'selected' : ''); ?>>Norway (Norwegian Bokmål)</option>
											<option value="sv-se" <?php esc_attr_e(($this->settings['lm_locale'] === "sv-se") ? 'selected' : ''); ?>>Sweden (Swedish)</option>
											<option value="de-de" <?php esc_attr_e(($this->settings['lm_locale'] === "de-de") ? 'selected' : ''); ?>>Germany (German)</option>
											<option value="en-us" <?php esc_attr_e(($this->settings['lm_locale'] === "en-us") ? 'selected' : ''); ?>>UK (English)</option>
											<option value="nl-nl" <?php esc_attr_e(($this->settings['lm_locale'] === "nl-nl") ? 'selected' : ''); ?>>Netherlands (Dutch)</option>
											<option value="es-es" <?php esc_attr_e(($this->settings['lm_locale'] === "es-es") ? 'selected' : ''); ?>>Spain (Spanish)</option>
											<option value="fi-fi" <?php esc_attr_e(($this->settings['lm_locale'] === "fi-fi") ? 'selected' : ''); ?>>Finland (Finnish)</option>
											<option value="fr-fr" <?php esc_attr_e(($this->settings['lm_locale'] === "fr-fr") ? 'selected' : ''); ?>>France (French)</option>
											<option value="et-ee" <?php esc_attr_e(($this->settings['lm_locale'] === "et-ee") ? 'selected' : ''); ?>>Estonia (Estonian)</option>
											<option value="it-it" <?php esc_attr_e(($this->settings['lm_locale'] === "it-it") ? 'selected' : ''); ?>>Italy (Italian)</option>
											<option value="lt-lt" <?php esc_attr_e(($this->settings['lm_locale'] === "lt-lt") ? 'selected' : ''); ?>>Lithuania (Lithuanian)</option>
											<option value="pl-pl" <?php esc_attr_e(($this->settings['lm_locale'] === "pl-pl") ? 'selected' : ''); ?>>Poland (Polish)</option>
										</select>
										<?php wp_nonce_field( $this->plugin->name, $this->plugin->name . '_nonce' ); ?>
										<input name="submit" type="submit" name="Submit" class="btn btn-success" value="<?php esc_attr_e( 'Save', 'legalmonster' ); ?>" />
									</form>
								</div>
							</div>
						</div>

						<div id="Signup" class="tabcontent" style="display: block;">
							<div class="postbox">
								<div class="inside">
									<h1>Step 1: Sign up for Legal Monster</h1>
									<p>To get started, you must create your Legal Monster account and follow the steps to create your cookie pop-up!</p>

									<a href="https://hubs.la/H0HH9_60" target="_blank" class="btn btn-success">Get a free account</a>
									
									<br>
									
									<h1>Step 2: Paste public key</h1>
									<p>Paste your public key in the below textfield and press save. Voila! </p>
									<strong><p><?php esc_html_e( 'Widget Public key', 'legalmonster' ); ?></p></strong>

									<form action="admin.php?page=<?php echo esc_html($this->plugin->name); ?>" method="post" class="form-inline">
											<input name="lm_insert_footer" id="lm_insert_footer" class="widefat form-input" rows="8" style="font-family:Courier New;" value="<?php echo esc_html($this->settings['lm_insert_footer']); ?>"></input>
									
										<?php wp_nonce_field( $this->plugin->name, $this->plugin->name . '_nonce' ); ?>
										<input name="submit" type="submit" name="Submit" class="btn btn-success" value="<?php esc_attr_e( 'Save', 'legalmonster' ); ?>" />
									</form>

									<br>

									<h3>How to find your public key?</h3>
									<p>
										To install your widget, you'll need your cookie widget's public key. 
										Go to the <a href="https://app.legalmonster.com">Legal Monster dashboard</a> and go to <i>"Widgets"</i> via the menu. Copy the string code shown in pink under public key. In the example image, the public key is <code>bDEsDsX76teFhHQZYDcWx7Hm</code>. Your widget public key <b>is different</b>. 
									</p>
									<img src="<?php echo plugin_dir_url( __DIR__ ).'views/img/install.png';?>" class="w-75">

								</div>
							</div>
						</div>
						<!-- /postbox -->
					</div>
					<!-- /normal-sortables -->
				</div>
				<!-- /post-body-content -->
				<!-- Sidebar -->
				<div id="postbox-container-1" class="postbox-container">
					<?php require_once( $this->plugin->folder . '/views/sidebar.php' ); ?>
				</div>
				<!-- /postbox-container -->
			</div>
		</div>
	</div>
</div>