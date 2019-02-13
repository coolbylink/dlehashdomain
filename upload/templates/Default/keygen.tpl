<form method="post">
<div class="pheading"><h2>Генератор ключей DataLife Engine</h2></div>
[if]
<div class="baseform">
	<table class="tableform">
		<tr>
			<td class="label">
				Введите домен:<span class="impot" style="color:#FF0000;">*</span><br /><font size="-5" color="#666666">Пример:</font> <font size="-5" color="#FF0000">{domain_example}</font>
			</td>
			<td><input type="text" maxlength="35" name="domain_name" placeholder="{domain_placeholder}" value="{domain_name}" class="f_input" /></td>
		</tr>
		<tr>
			<td class="label">
				Версия скрипта:<span class="impot" style="color:#FF0000;">*</span>
			</td>
			<td>
                <select style="padding:2px 7px 2px 7px;" name="hash_version">
                	<option value="FR000">-- Выберите версию --</option>
                    {version}
                </select>
            </td>
		</tr>
		[sec_code]<tr>
			<td class="label">
				Введите код:<span class="impot" style="color:#FF0000;">*</span>
			</td>
			<td>
				<div>{code}</div>
				<div><input type="text" maxlength="45" name="sec_code" style="width:155px" class="f_input" /></div>
			</td>
		</tr>[/sec_code]
		[recaptcha]<tr>
			<td class="label">
				Введите два слова, показанных на изображении:<span class="impot" style="color:#FF0000;">*</span>
			</td>
			<td>
				<div>{recaptcha}</div>
			</td>
		</tr>[/recaptcha]
	</table>
    
	<div class="fieldsubmit">
		<input type="submit" name="keygen" class="fbutton" style="width:150px;" type="submit" value="Создать ключ" />&nbsp;&nbsp;&nbsp;&nbsp;<br><br><span class="small">Об использовании пиратской версии прочтите  [ <a href="javascript:ShowOrHide('pr_keygen')"><b>ПИРАТСКАЯ ВЕРСИЯ</b></a> ] </span>
	</div>
</div>
[/if]
[else]
[else_logged]<input type="hidden" name="domain_name" value="{domain}" />[/else_logged]
<input type="hidden" name="ltrm" value="1" />
<div class="baseform">
	<table class="tableform">
		<tr>
			<td class="label">
				Доменное имя:
			</td>
			<td>[if_logged]<input type="text" maxlength="35" name="domain_name" placeholder="{domain_placeholder}" value="{domain_name}" class="f_input" />[/if_logged][else_logged]{domain}[/else_logged]</td>
		</tr>
        [idn]
		<tr>
			<td class="label">
				IDN Конвертор:
			</td>
			<td>{domain_idn}</td>
		</tr>
        [/idn]
		<tr>
			<td class="label">
				Версия скрипта:
			</td>
			<td>
                <select [else_logged]disabled="disabled"[/else_logged] style="padding:2px 7px 2px 7px;" name="hash_version">
                	<option value="FR000">-- Выберите версию --</option>
                    {version}
                </select>
            </td>
		</tr>
		<tr>
			<td class="label">
				Хеш домена:
			</td>
			<td><input type="text" maxlength="35" class="f_input" value="{hash_domain}" readonly /></td>
		</tr>
        <tr>
            <td class="label">DataLife Engine:</td>
            <td>Откройте файл <b>/engine/data/config.php</b><br />Добавьте строку</td>
        </tr>
		<tr>
        	<td class="label"></td>
			<td><font style="background:#235300; color:#FFFFFF; font-weight:bold; padding:1px 4px 1px 4px;">'key' => "{hash_domain}",</font></td>
		</tr>
	</table>
	<div class="fieldsubmit">
		[if_logged]<input type="submit" name="keygen" class="fbutton" style="width:150px;" type="submit" value="Изменить" />&nbsp;&nbsp;[/if_logged]<button onclick="window.history.back();" class="fbutton" name="send_btn" style="width:150px;" type="submit"><span>Вернутся назад</span></button>&nbsp;&nbsp;&nbsp;&nbsp;<span class="small">Об использовании пиратской версии прочтите  [ <a href="javascript:ShowOrHide('pr_keygen')"><b>ПИРАТСКАЯ ВЕРСИЯ</b></a> ] </span>
	</div>
</div>
[/else]
</form>
<div class="basecont"><br>
    <div id="pr_keygen" style="display:none;">
        <div class="dpad">
            <div class="storenumber" style="color:#060; margin-bottom:3px;">Преимущества приобретения лицензионной версии:</div>
            &bull; Вы получаете лицензию, оформленную на вас<br />
            &bull; Право на неограниченное по времени использование DLE<br />
            &bull; Лицензионное соглашение и чек о легальности покупки - БЕСПЛАТНО<br />
            &bull; Право на БЕСПЛАТНОЕ обновление всех будущих версий<br />
            &bull; Возможность получения индивидуальных критических обновлений и патчей<br />
            &bull; Возможность полного доступа к официальному сайту http://dle-news.ru<br />
            &bull; Идентификацию Вас, как официального пользователя DLE<br />
            &bull; Ваши предложения будут учтены при разработке новых версий DLE<br /><br />
            
            <div class="storenumber" style="color:#900; margin-bottom:3px;">При использовании пиратской версии:</div>
            &bull; Эта версия может внезапно начать работать неправильно, или совсем перестать работать<br />
            &bull; Никто не будет отвечать за неработоспособность "крякнутого" DLE<br />
            &bull; Вы не сможете получать обновления/патчи<br />
            &bull; У вас не будет технической поддержки<br />
            &bull; Не будет официальных документов, подтверждающих покупку<br />
            &bull; Попадаете под статью 146 УК РФ "Нарушение авторских и смежных прав"<br />
            &bull; Не сделаете лучше ни для себя, ни для разработчиков
        </div>
    </div>
</div>