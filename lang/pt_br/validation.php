<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'O campo :attribute deve ser aceito.',
    'accepted_if' => 'O campo :attribute deve ser aceito quando o valor de :other for :value.',
    'active_url' => 'O campo :attribute deve ser um URL válido.',
    'after' => 'O campo :attribute deve estar em uma data após :date.',
    'after_or_equal' => 'O campo :attribute deve estar em uma data após ou em :date.',
    'alpha' => 'O campo :attribute deve conter somente letras.',
    'alpha_dash' => 'O campo :attribute deve conter apenas letras, números, traços ou sublinhas.',
    'alpha_num' => 'O campo :attribute deve conter apenas letras e números.',
    'array' => 'O campo :attribute deve ser um arranjo.',
    'ascii' => 'O campo :attribute deve conter apenas caracteres ASCII e símbolos.',
    'before' => 'O campo :attribute deve estar em uma data anterior a :date.',
    'before_or_equal' => 'O campo :attribute deve estar em uma data anterior a ou em :date.',
    'between' => [
        'array' => 'O campo :attribute deve estar entre :min e :max itens.',
        'file' => 'O campo :attribute deve estar entre :min e :max kilobytes.',
        'numeric' => 'O campo :attribute deve estar entre :min e :max.',
        'string' => 'O campo :attribute deve estar entre :min e :max caracteres.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'can' => 'O campo :attribute contém um valor não autorizado.',
    'confirmed' => 'O campo de confirmação :attribute não confere.',
    'current_password' => 'A senha está incorreta.',
    'date' => 'O campo :attribute deve ser uma data válida.',
    'date_equals' => 'O campo :attribute deve estar em uma data equivalente a :date.',
    'date_format' => 'O campo :attribute deve combinar com o formato :format.',
    'decimal' => 'O campo :attribute deve conter :decimal casas decimais.',
    'declined' => 'O campo :attribute deve ser rejeitado.',
    'declined_if' => 'O campo :attribute deve ser rejeitado quando :other for :value.',
    'different' => 'O campo :attribute e :other deve ser diferente.',
    'digits' => 'O campo :attribute deve conter :digits dígitos.',
    'digits_between' => 'O campo :attribute deve estar entre :min e :max dígitos.',
    'dimensions' => 'O campo :attribute possui dimensões de imagem inválidas.',
    'distinct' => 'O campo :attribute possui valor duplicado.',
    'doesnt_end_with' => 'O campo :attribute não deve terminar com: :values.',
    'doesnt_start_with' => 'O campo :attribute não deve começar com: :values.',
    'email' => 'O campo :attribute deve ser um endereço de email válido.',
    'ends_with' => 'O campo :attribute deve terminar com: :values.',
    'enum' => 'O valor selecionado :attribute é inválido.',
    'exists' => 'O valor selecionado :attribute é inválido.',
    'file' => 'O campo :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve conter um valor.',
    'gt' => [
        'array' => 'O campo :attribute deve conter mais de :value itens.',
        'file' => 'O campo :attribute deve ser maior que :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser maior que :value.',
        'string' => 'O campo :attribute deve conter mais de :value caracteres.',
    ],
    'gte' => [
        'array' => 'O campo :attribute deve conter :value ou mais itens.',
        'file' => 'O campo :attribute deve ser maior ou igual a :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser maior ou igual a :value.',
        'string' => 'O campo :attribute deve conter :value ou mais caracteres.',
    ],
    'image' => 'O campo :attribute deve ser uma imagem.',
    'in' => 'O valor selecionado :attribute é inválido.',
    'in_array' => 'O campo :attribute deve conter em :other.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',
    'ip' => 'O campo :attribute deve ser um endereço de IP válido.',
    'ipv4' => 'O campo :attribute deve um endereço IPv4 válido.',
    'ipv6' => 'O campo :attribute deve ser um endereço IPv6 válido.',
    'json' => 'O campo :attribute deve ser um valor JSON válido.',
    'lowercase' => 'O campo :attribute deve estar em letras minúsculas.',
    'lt' => [
        'array' => 'O campo :attribute deve conter menos de :value itens.',
        'file' => 'O campo :attribute deve ser menor que :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser menor que :value.',
        'string' => 'O campo :attribute deve conter menos de :value caracteres.',
    ],
    'lte' => [
        'array' => 'O campo :attribute deve conter :value ou menos itens.',
        'file' => 'O campo :attribute deve ser menor ou igual a :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser menor ou igual a :value.',
        'string' => 'O campo :attribute deve conter :value ou menos caracteres.',
    ],
    'mac_address' => 'O campo :attribute deve ser um endereço MAC válido.',
    'max' => [
        'array' => 'O campo :attribute não deve ter mais de :max itens.',
        'file' => 'O campo :attribute não deve ter mais de :max kilobytes.',
        'numeric' => 'O campo :attribute não deve ter mais de :max.',
        'string' => 'O campo :attribute não deve ter mais de :max caracteres.',
    ],
    'max_digits' => 'O campo :attribute não deve ter mais de :max dígitos.',
    'mimes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'array' => 'O campo :attribute deve ter pelo menos :min itens.',
        'file' => 'O campo :attribute deve ter pelo menos :min kilobytes.',
        'numeric' => 'O campo :attribute deve ter pelo menos :min.',
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'min_digits' => 'O campo :attribute deve ter pelo menos :min dígitos.',
    'missing' => 'O campo :attribute deve estar ausente.',
    'missing_if' => 'O campo :attribute deve estar faltando quando :other for :value.',
    'missing_unless' => 'O campo :attribute deve estar faltando ao menos que :other seja :value.',
    'missing_with' => 'O campo :attribute deve estar faltando quando :values está presente.',
    'missing_with_all' => 'O campo :attribute deve estar faltando quando :values estão presentes.',
    'multiple_of' => 'O campo :attribute deve ser um múltiplo de :value.',
    'not_in' => 'O campo selecionado :attribute é inválido.',
    'not_regex' => 'O formato do campo :attribute é inválido.',
    'numeric' => 'O campo :attribute deve ser um número.',
    'password' => [
        'letters' => 'O campo :attribute deve conter pelo menos uma letra.',
        'mixed' => 'O campo :attribute deve conter pelo menos uma letra maiúscula ou minúscula.',
        'numbers' => 'O campo :attribute deve conter pelo menos um número.',
        'symbols' => 'O campo :attribute deve conter pelo menos um símbolo.',
        'uncompromised' => ':attribute apareceu em um vazamento de dados. Por favor escolha um :attribute diferente.',
    ],
    'present' => 'O campo :attribute deve estar presente.',
    'present_if' => 'O campo :attribute deve estar presente quando :other for :value.',
    'present_unless' => 'O campo :attribute deve estar presente ao menos que :other seja :value.',
    'present_with' => 'O campo :attribute deve estar presente quando :values está presente.',
    'present_with_all' => 'O campo :attribute deve estar presente quando :values estão presentes.',
    'prohibited' => 'O campo :attribute é proibido.',
    'prohibited_if' => 'O campo :attribute é proibido quando :other for :value.',
    'prohibited_unless' => 'O campo :attribute é proibido ao menos que :other esteja em :values.',
    'prohibits' => 'O campo :attribute proíbe :other de estar presente.',
    'regex' => 'O formato do campo campo :attribute é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_array_keys' => 'O campo :attribute deve conter os dados: :values.',
    'required_if' => 'O campo :attribute é obrigatório quando :other for :value.',
    'required_if_accepted' => 'O campo :attribute é obrigatório quando :other for aceito.',
    'required_unless' => 'O campo :attribute é obrigatório ao menos que :other esteja em :values.',
    'required_with' => 'O campo :attribute é obrigatório quando :values é presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando :values estão presentes.',
    'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando none of :values não estão presentes.',
    'same' => 'O campo :attribute deve combinar com :other.',
    'size' => [
        'array' => 'O campo :attribute deve conter :size itens.',
        'file' => 'O campo :attribute deve conter :size kilobytes.',
        'numeric' => 'O campo :attribute dever ser :size.',
        'string' => 'O campo :attribute deve conter :size caracteres.',
    ],
    'starts_with' => 'O campo :attribute deve começar com os seguintes valores: :values.',
    'string' => 'O campo :attribute deve ser um texto.',
    'timezone' => 'O campo :attribute deve ser um fuso horário válido.',
    'unique' => 'O campo :attribute já existe.',
    'uploaded' => 'O campo :attribute falhou em subir o arquivo.',
    'uppercase' => 'O campo :attribute deve estar em letras maiúsculas.',
    'url' => 'O campo :attribute deve ser um URL válido.',
    'ulid' => 'O campo :attribute deve ser um ULID válido.',
    'uuid' => 'O campo :attribute deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
		'version_files.*.file'	=> [
			'mimes'		=> 'O arquivo enviado deve ser dos tipos: :values.',
		],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
