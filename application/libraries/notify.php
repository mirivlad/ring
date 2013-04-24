<?php

/**
 * Notify – класс уведомлений пользователя для Codeigniter
 *
 * Пример применения в php:
 *
 * Вывод одной ошибки или сообщения
 * $this->notify->returnError('Текст ошибки');
 *
 * Вывод нескольких сообщений
 * $this->notify->error('Случилась какая-то ошибка');
 * $this->notify->success('Но основную часть мы выполнили');
 * $this->notify->returnNotify();
 *
 * @package codeigniter-notify-library
 * @author Eduardo Kozachek <eduard.kozachek@gmail.com>
 * @version $Revision: 1.03 $
 * @access public
 * @see http://nadvoe.org.ua
 * @changed 25.05.12 19:21
 */
class Notify {

    private $notify,
	    $returnTo,
	    $ci_session,
	    $additionalData,
	    $mustDie = true,
	    $returnResult,
	    $region = 'default',
	    $ttl = 5,
	    $silent;
    private $css = "
	
		/** Notification **/
		.notify
		{
			display:block;
			position:fixed;
			top:20px;
			right:20px;
			z-index: 5000;
		}

	
	";
    private $js = '';

    /**
     * Конструктор сохраняет сессию внутри этого класса и выставляет флаги запроса
     *
     * @access public
     */
    function __construct() {
	// загружаем Codeigniter
	$this->_ci = & get_instance();

	// загружаем сессию
	$this->ci_session = $this->_ci->session;

	$this->_ci->config->load('notify', true);
	$this->ttl = $this->_ci->config->item('fade_timeout', 'notify');
    }

    /**
     * Функция выводящая сохраненные в библиотеке стили и javascript
     * Ее подключение обязательно
     *
     * @global string $this->css - стили
     * @global string $this->js - скрипты
     * @return string HTML
     * @access public
     */
    public function initJsCss() {
	$html = '<!--Notify-->';
	$html .= '<style>' . $this->css . '</style>';
	$html .= '<script type="text/javascript">';
	$html .= 'window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function(){
			    $(this).remove(); 
			});
		    }, '.$this->ttl.');';
	$html .= $this->js;
	$html .= '</script>';
	$html .= '<!--Notify-->';

	return $html;
    }

    public function initJs($in_html = false) {
	$html = '';
	if ($in_html)
	    $html .= '<!--Notify--><script type="text/javascript">';
	$html .= '/* Notify */';
	$html .= '';
	$html .= $this->js;
	$html .= '/* Notify */';
	if ($in_html)
	    $html .= '</script><!--Notify-->';

	return $html;
    }

    public function initCss($in_html = false) {
	$html = '';
	if ($in_html)
	    $html .= '<!--Notify--><style>';
	$html .= '/* Notify */';
	$html .= $this->css;
	$html .= '/* Notify */';
	if ($in_html)
	    $html .= '</style><!--Notify-->';

	return $html;
    }

    /**
     * Основная функция возврата
     * На ней выполнение скрипта завершается
     *
     * @param string $json двумерный массив с типом сообщения и текстом
     * @global string $_SERVER['HTTP_REFERER'] | $this->returnTo - адрес предыдущей страницы
     * @uses Session Сессии codeigniter
     * @uses base_url() Функция возвращающая корневую директорию
     * @uses site_url() Функция преобразования путей приложения
     * @return array Сохраняет массив сообщений в сессию
     * @return json Выдает json-массив в javascript
     * @access public
     */
    public function returnNotify() {
	if ($this->returnTo != '') {
	    if ($this->returnTo == '/')
		$this->returnTo = base_url();
	    elseif (strstr($this->returnTo, 'http://') or strstr($this->returnTo, 'https://'))
		$this->returnTo = $this->returnTo;
	    else
		$this->returnTo = site_url($this->returnTo);
	}

	$json = $this->notify;

	$json['data'] = $this->additionalData;

	if ($this->_ci->input->is_ajax_request()) {
	    $json['comeback'] = $this->returnTo;
	    $json = json_encode($json);
	    die($json);
	} else {
	    if ($this->returnTo == '') {
		if (isset($_SERVER['HTTP_REFERER']))
		    $this->returnTo = $_SERVER['HTTP_REFERER'];
		else
		    $this->returnTo = base_url();
	    }


	    $data = $this->ci_session->userdata('notify');

	    if ($data && is_array($data)) {
		$json = array_merge($data, $json);
	    }

	    $this->ci_session->set_userdata('notify', $json);

	    if ($this->mustDie) {
		redirect($this->returnTo);
		$this->returnTo = '';
		die();
	    }
	    else
		return $this->returnResult OR false;
	}
    }

    /**
     * Добавление ошибки в очередь
     *
     * @param string $message - Текст сообщения
     * @param string $ttl - Время жизни, 0 - неограничено
     * @param string $region - Регион для вывода сообщения
     * @global string $this->notify - очередь сообщений
     * @access public
     */
    public function error($message, $ttl = null, $region = null) {
	if (!$this->silent) {
	    $this->notify[] = array(
		"isError" => 1,
		"type" => "error",
		"message" => $message,
		"region" => !is_null($region) ? $region : $this->region,
		"ttl" => !is_null($ttl) ? $ttl : $this->ttl
	    );
	}
    }

    /**
     * Добавление сообщения в очередь
     *
     * @param string $message - Текст сообщения
     * @param string $ttl - Время жизни, 0 - неограничено
     * @param string $region - Регион для вывода сообщения
     * @global string $this->notify - очередь сообщений
     * @access public
     */
    public function success($message, $ttl = null, $region = null) {
	if (!$this->silent) {
	    $this->notify[] = array(
		"isError" => 0,
		"type" => "success",
		"message" => $message,
		"region" => !is_null($region) ? $region : $this->region,
		"ttl" => !is_null($ttl) ? $ttl : $this->ttl
	    );
	}
    }

    /**
     * Добавление сообщения в очередь и прекращение выполнение скрипта
     *
     * @param string $message - Текст сообщения
     * @param string $ttl - Время жизни, 0 - неограничено
     * @param string $region - Регион для вывода сообщения
     * @access public
     */
    public function returnError($message, $ttl = null, $region = null) {
	$this->error($message, $ttl, $region);

	$this->returnResult = false;

	return $this->returnNotify();
    }

    /**
     * Добавление сообщения в очередь и прекращение выполнение скрипта
     *
     * @param string $message - Текст сообщения
     * @param string $ttl - Время жизни, 0 - неограничено
     * @param string $region - Регион для вывода сообщения
     * @access public
     */
    public function returnSuccess($message, $ttl = null, $region = null) {
	$this->success($message, $ttl, $region);

	$this->returnResult = true;

	return $this->returnNotify();
    }

    /**
     * Добавление данных в ответ
     *
     * @param array $data - Данные
     * @global string $this->additionalData - данные
     * @access public
     */
    public function setData($data) {
	$this->additionalData = $data;
    }

    /**
     * Получение данных из ответа
     *
     * @global string $this->additionalData - данные
     * @global string $this->ci_session - сессия
     * @access public
     */
    public function getData() {
	// уведомления текущего запроса
	if (isset($this->additionalData))
	    $additionalData = $this->additionalData;
	else {
	    $sess = $this->ci_session->userdata('notify');

	    if (isset($sess['data']) && $sess['data']) {
		$additionalData = $sess['data'];
	    }
	    else
		$additionalData = '';
	}

	// уведомления предыдущего запроса

	return $additionalData;
    }

    /**
     * Установка адреса перенаправления
     *
     * @param string $url - URL
     * @global string $this->returnTo - URL
     * @access public
     */
    public function setComeback($url) {
	$this->returnTo = $url;
    }

    /**
     * Вывод и очистка очереди сообщений
     *
     * @global string $this->notify - Очередь сообщений
     * @uses Session CI_Session
     * @access public
     */
    public function getMessages($region = 'default') {

	// уведомления текущего запроса
	if (isset($this->notify) && is_array($this->notify) && count($this->notify))
	    $notifies = $this->notify;
	else
	    $notifies = array();

	// уведомления предыдущего запроса
	$sess = $this->ci_session->userdata('notify');

	if (isset($sess) && is_array($sess) && count($sess))
	    $notifies = array_merge($notifies, $sess);

	// вывод
	$html = '';

	if (isset($notifies) && is_array($notifies) && count($notifies)) {
	    foreach ($notifies as $field => $n) {
		if (is_array($n) && !isset($n['type'])) {
		    foreach ($n as $key => $nn) {
			if (isset($nn['region']) && $region == $nn['region'] && isset($nn['message']) && $nn['message']) {
			    $html .= '<div class="alert alert-'.$nn['type'].'">
				<button type="button" class="close" data-dismiss="alert">×</button>
				' . $nn['message'] . '
				 </div>';
			    unset($notifies[$field]);
			}
		    }
		} else {
		    if (isset($n['region']) && $region == $n['region'] && isset($n['message']) && $n['message']) {
			$html .= '<div class="alert alert-'.$n['type'].'">
				<button type="button" class="close" data-dismiss="alert">×</button>
				' . $n['message'] . '
				 </div>';

			unset($notifies[$field]);
		    }
		}
	    }
	}

	if (!count($notifies))
	    $this->ci_session->unset_userdata('notify');
	else
	    $this->ci_session->set_userdata('notify', $notifies);

	return '<div class="notify ' . $region . '">' . $html . '</div>';
    }

    /**
     * Метод для предотвращения прекращения выполнения скрипта 
     *
     * @param bool $mustDie - Включение/выключение прерывания скрипта
     * @access public
     */
    public function mustDie($mustDie = true) {
	$this->mustDie = (bool) $mustDie;
    }

    /**
     * Метод для предотвращения прекращения выполнения скрипта 
     *
     * @param bool $mustDie - Включение/выключение прерывания скрипта
     * @access public
     */
    public function setSilence($mode = false) {
	$this->silent = (bool) $mode;
    }

    /**
     * Метод для выбора места в скрипте, где именно выводить сообщения
     *
     * @param bool $mustDie - Включение/выключение прерывания скрипта
     * @access public
     */
    public function setRegion($nameRegion = 'default') {
	$this->region = $nameRegion;
    }

    /**
     * Метод установки времени жизни сообщения
     *
     * @param bool $mustDie - Включение/выключение прерывания скрипта
     * @access public
     */
    public function setTtl($ttl = 5) {
	$this->ttl = $ttl;
    }

}