<div class="footerNav">
	<a href="<?=site_url()?>" data-title="Hives" <?=!$this->uri->segment(1) ? "class='active'" : ""?>>Main</a>
	<a href="<?=site_url('conversations')?>" <?=$this->uri->segment(1) == "conversations" ? "class='active'" : ""?> data-title="Conversations | Hives">Conversations</a>
	<a href="/notifications" <?=$this->uri->segment(1) == "notifications" ? "class='active'" : ""?> data-title="Notifications | Hives">Notifications</a>
	<a href="/contacts" <?=$this->uri->segment(1) == "contacts" ? "class='active'" : ""?> data-title="Contacts | Hives">Contacts</a>
	<a href="/hives" <?=$this->uri->segment(1) == "hives" ? "class='active'" : ""?> data-title="Hives | Hives">Hives</a>
	<a href="/vault" <?=$this->uri->segment(1) == "vault" ? "class='active'" : ""?> data-title="Vault | Hives">Vault</a>
	<a href="/preferences" <?=$this->uri->segment(1) == "preferences" ? "class='active'" : ""?> data-title="Preferences | Hives">Preferences</a>
</div>
