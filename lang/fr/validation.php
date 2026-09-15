<?php

return [
    'accepted' => ':attribute doit être accepté(e).',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'max' => [
        'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
    ],
    'min' => [
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],
    'required' => 'Le champ :attribute est obligatoire.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'unique' => 'Cette valeur pour :attribute est déjà utilisée.',

    'custom' => [
        'password' => [
            'min' => 'Le mot de passe doit contenir au moins :min caractères.',
        ],
    ],

    'attributes' => [
        'first_name' => 'prénom',
        'last_name' => 'nom',
        'class_name' => 'classe',
        'email' => 'e-mail',
        'password' => 'mot de passe',
        'password_confirmation' => 'confirmation du mot de passe',
    ],
];
