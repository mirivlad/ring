<?php

 /**
 * @package utilites library
 * @author Mirivlad
 * @version $Revision: 1.00 $
 * @access public
 * @changed 02.05.2013
 */
class Utils {

     /**
     * Конструктор сохраняет сессию внутри этого класса и выставляет флаги запроса
     *
     * @access public
     */
    function __construct() {
	// загружаем Codeigniter
	$this->_ci = & get_instance();
    }
    /**
     * Преобразует объект и все вложеные в него объекты в массив и вложенные массивы
     * @param object $object
     * @return array $array
     */
    function object_to_array( $object )
    {
        if( !is_object( $object ) && !is_array( $object ) )
        {
            return $object;
        }
        if( is_object( $object ) )
        {
            $object = get_object_vars( $object );
        }
        return array_map( array($this, 'object_to_array'), $object );
    }
    
    /**
     * 
     * @param string $user_id user id
     * @return string $avatar url to user avatar
     */
    public function upload_avatar($user_id=''){
        $ci = $this->_ci;
        $config['upload_path'] = './assets/img/avatars/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '150';
        $config['max_width']  = '64';
        $config['max_height']  = '64';
        $config['overwrite'] = FALSE;
        $config['file_name'] = time().$user_id.base64_encode($user_id);
        $ci->load->library('upload', $config);
        if ( ! $ci->upload->do_upload('avatar')){
            return $ci->upload->display_errors();
	}else{
                $avatar = $ci->upload->data();
                if ($this->user_get_avatar($user_id) != 'default.png'){
                    unlink("/assets/img/avatars/".$this->user_get_avatar($user_id));
                }
                $data = array("avatar"=>$avatar['file_name']);
                $ci->user_profile->set_profile($user_id, $data);
                return '';
        }
    }
    
    public function user_get_avatar($user_id=''){
        $ci = $this->_ci;
        if (!isset($user_id) OR $user_id == '') {
            $user_id = $ci->dx_auth->get_user_id();
        }
        $ava_query = $ci->user_profile->get_profile_field($user_id, "avatar")->result();
        if(count($ava_query)){
            $avatar = $ava_query[0]->avatar;
        }else{
            $avatar = 'default.png';
        }
        return $avatar;
    }

}