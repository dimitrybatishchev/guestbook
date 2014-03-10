<?php

namespace Form;

class FileUploader{

    /*
     *
     */
    public function __construct(){

    }

    /**
     * @param $uploadDir
     * @param $inputName
     * @param $validTypes
     * @param $maxImageSize
     * @return mixed
     */
    public function upload($uploadDir, $inputName, $validTypes, $maxImageSize){
        if (empty($_FILES[$inputName])){
            return null;
        }
        if ($_FILES[$inputName]['tmp_name']) {
            if (is_uploaded_file($_FILES[$inputName]['tmp_name'])) {
                $filename = $_FILES[$inputName]['tmp_name'];
                $ext = explode('.',$_FILES[$inputName]['name']);
                $extension = $ext[1];
                $newname = $ext[0].'_'.time() . '.' . $extension;
                if (filesize($filename) > $maxImageSize) {
                    echo 'Error: File size > 64K.';
                } elseif (!in_array($extension, $validTypes)) {
                    echo 'Error: Invalid file type.';
                } else {
                    if ($extension == 'txt'){
                        if (filesize($filename) < 100000){
                            //if (move_uploaded_file($filename, 'C:\wamp\www\guestbook\web\uploads\\' . $_FILES['userfile']['name'])) {
                            if (move_uploaded_file($filename, 'C:\wamp\www\guestbook\web\uploads\\' . $newname)) {
                                echo 'File successful uploaded.';
                                return $newname;
                            } else {
                                echo 'Error: moving fie failed.';
                            }
                        } else {
                            #todo: throw error;
                            echo 'eroor';
                        }
                    } else {
                        $size = getimagesize($filename);
                        var_dump('ok');
                        if (($size)) {
                            if (move_uploaded_file($filename, 'C:\wamp\www\guestbook\web\uploads\\' . $newname)) {
                                echo 'File successful uploaded.';
                                return $newname;
                            } else {
                                echo 'Error: moving fie failed.';
                            }
                        } else {
                            echo 'Error: invalid image properties.';
                        }
                    }
                }
            } else {
                echo "Error: empty file.";
            }
        }
    }

}