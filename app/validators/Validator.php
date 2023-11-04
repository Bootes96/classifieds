<?php

namespace app\validators;

class Validator {

    public array $errors = [];

    public function validateAllFields($data) {

        $validatedFields = [];

        $validatedFields['title'] = array_key_exists('title', $data) ? $this->validateTitle($data['title']) : $this->errors['title'] = 'Пожалуйста, заполните поле';
        $validatedFields['description'] = array_key_exists('description', $data) ? $this->validateDesc($data['description']) : $this->errors['description'] = 'Пожалуйста, заполните поле';
        $validatedFields['main_img'] = array_key_exists('main_img', $data) ? $this->validateImg($data['main_img']) : $this->errors['main_img'] = 'Пожалуйста, заполните поле';
        $validatedFields['price'] = array_key_exists('price', $data) ? $this->validatePrice($data['price']) : $this->errors['price'] = 'Пожалуйста, заполните поле';

        foreach ($validatedFields as $key => $val) {
            if($val !== true) {
                $this->errors[$key] = $val; 
            }
        }

        return $this->errors;
    }

    public function validateTitle(string $title) 
    {
        $errors = [];
        $titleLength = mb_strlen($title);
        $pattern = "/^[А-ЯЁ]([\s\-\']?[а-яёА-ЯЁ0-9][\s\-\']?)*$/u";

        if(!$titleLength) {
            $errors[] = "Пожалуйста, заполните поле";
        } elseif ($titleLength > 200) {
            $errors[] = "Название объявления не должно быть длиннее 200 символов, вы ввели $titleLength";
        } elseif (!preg_match($pattern, $title)) {
            $errors[] = "Название должно состоять только из русских символов и начинаться с большой буквы";
        }

        return !empty($errors) ? $errors : true;
    }

    public function validateDesc(string $description) 
    {
        $errors = [];
        $descLength = mb_strlen($description);

        if(!$descLength) {
            $errors[] = "Пожалуйста, заполните поле";
        } elseif ($descLength > 200) {
            $errors[] = "Описание не должно быть длиннее 1000 символов, вы ввели $descLength";
        }

        return !empty($errors) ? $errors : true;
    }

    public function validateImg(string $img) {
        $errors = [];
        $imgLength = mb_strlen($img);

        if(!$imgLength) {
            $errors[] =  "Пожалуйста, заполните поле";
        }

        return !empty($errors) ? $errors : true;
    }

    public function validatePrice(int $price) {
        $errors = [];

        if(!$price) {
            $errors[] = "Пожалуйста, заполните поле";
        } elseif ($price < 0) {
            $errors[] = "Цена не может быть отрицательной";
        }

        return !empty($errors) ? $errors : true; 
    }

}