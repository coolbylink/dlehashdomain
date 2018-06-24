<article class="box story">
	[if]
    <form method="post">
	<div class="box_in dark_top stats_head">
		<h1 class="title">{description}</h1>
		<ul>
			<li class="stats_d"><b>При использовании пиратской версии:</b> <span>
                &bull; Вы не сможете получать обновления/патчи<br />
                &bull; У вас не будет технической поддержки<br />
                &bull; Не будет официальных документов, подтверждающих покупку<br />
                &bull; Попадаете под статью 146 УК РФ "Нарушение авторских и смежных прав"<br />
                &bull; Не сделаете лучше ни для себя, ни для разработчиков
            </span></li>
            <li class="stats_m"><b>v{version} (DataLife Engine: v{last_version_hash})</b> <span>Активация DataLife Engine через генератор ключей служит для ознакомительных целей, настоятельно рекомендуем приобрести данный скрипт на сайте: <a href="http://dle-news.ru/" target="_blank">dle-news.ru</a></span></li>
		</ul>
	</div>
	<div class="box_in">
		<div class="text page_form__inner page_form__form">
        
            <ul class="ui-form">
                <li class="form-group">
                    <label for="domain">Домен:<span class="impot" style="color:#FF0000;">*</span><br /><font size="-5" color="#666666">Пример:</font> <font size="-5" color="#FF0000">{example}</font> / <font size="-5" color="#34942f">(Есть поддержка: IDN)</font></label>
                    <div class="login_check">
                        <input type="text" name="domain" id="domain" placeholder="{example}" class="wide" required>
                    </div>
                    <div id="result-registration"></div>
                </li>
                <li class="form-group">
                    <label for="version">Версия скрипта:<span class="impot" style="color:#FF0000;">*</span></label>
                    <div class="login_check">
                        <select name="hash_version" id="version">
                            {select_hash}
                        </select>
                    </div>
                    <div id="result-registration"></div>
                </li>
                [recaptcha]
                    <li class="form-group">{recaptcha}</li>
                [/recaptcha]
            </ul>
			<div class="form_submit">
				[sec_code]
					<div class="c-captcha">
						{code}
						<input placeholder="Повторите код" title="Введите код указанный на картинке" type="text" name="sec_code" id="sec_code" required>
					</div>
				[/sec_code]
				<input class="btn btn-big" type="submit" name="send_btn" value="Создать ключ">
			</div>
        
        </div>
	</div>
    </form>
    [/if]
    [else]
    <form method="post">
    	<div class="box_in">
        	<h1 class="title">{description}</h1>
        
            <div class="text page_form__inner page_form__form">
            
                <ul class="ui-form">
                	[group=5]
                    <li class="form-group">
                        <label for="domain">Доменное имя:</label>
                        <div class="login_check">
                            {domain}
                        </div>
                        <div id="result-registration"></div>
                    </li>
                    [/group]
                    [not-group=5]
                    <li class="form-group">
                        <label for="domain">Домен:<span class="impot" style="color:#FF0000;">*</span><br /><font size="-5" color="#666666">Пример:</font> <font size="-5" color="#FF0000">{example}</font> / <font size="-5" color="#34942f">(Есть поддержка: IDN)</font></label>
                        <div class="login_check">
                            <input type="text" name="domain" id="domain" value="{domain}" onclick="this.select();" class="wide" required>
                        </div>
                        <div id="result-registration"></div>
                    </li>
                    [/not-group]
                    [idn]
                    <li class="form-group">
                        <label for="idn">IDN Конвертор:</label>
                        <div class="login_check">
                            {domain_idn}
                        </div>
                        <div id="result-registration"></div>
                    </li>
                    [/idn]
                    <li class="form-group">
                        <label for="version">Версия скрипта:<span class="impot" style="color:#FF0000;">*</span></label>
                        <div class="login_check">
                            <select name="hash_version" [group=5] disabled="disabled" [/group] id="version">
                                {select_hash}
                            </select>
                        </div>
                        <div id="result-registration"></div>
                    </li>
                    <li class="form-group">
                        <label for="hash">Хеш домена:</label>
                        <div class="login_check">
                            <input type="text" id="domain" value="{hash_domain}" onclick="this.select();" class="wide" readonly>
                        </div>
                        <div id="result-registration"></div>
                    </li>
                    <li class="form-group">
                        <label for="dle">DataLife Engine:</label>
                        <div class="login_check">
                            Откройте файл <b>/engine/data/config.php</b><br />Добавьте строку
                        </div>
                        <div class="login_check">
                            <font style="background:#235300; color:#FFFFFF; font-weight:bold; padding:1px 4px 1px 4px;">'key' => "{hash_domain}",</font>
                        </div>
                        <div id="result-registration"></div>
                    </li>
                    [download]
                    <li class="form-group">
                    	<div class="form_submit">
                        <label for="hash">Мини активатор:</label><br />
                        <font size="-1" color="#666666">Сгенерированный keygen.php файл, служит для автоматической активации DataLife Engine.<br />Файл автоматически впишет в config за Вас выше указанный хеш домена.<br /><br />Закиньте данный файл в корень вашего сайта и перейдите в него, тем самым вы автоматически активируете вашу версию.</font><br />
                        <input type="submit" name="download" value="Файл: keygen.php" />
                        </div>
                        <div id="result-registration"></div>
                    </li>
                    [/download]
                </ul>
               <div class="form_submit">
               		<a href="/index.php?do=keygen"><span>Вернутся назад</span></a>
               		[not-group=5]&nbsp;&nbsp;<input class="btn btn-big" type="submit" name="send_btn" value="Создать ключ">[/not-group]
               </div>
           </div>
           
        </div>
    </form>
    [/else]
</article>