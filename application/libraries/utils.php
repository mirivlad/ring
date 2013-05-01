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
    public function upload_avatar($avatar){
        
    }


}