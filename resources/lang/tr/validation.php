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

    'accepted' => 'The :attribute kabul edilmelidir.',
    'active_url' => 'The: attribute geçerli bir URL değil',
    'after' => 'The :attribute tarihinden sonraki bir tarih olmalıdır.',
    'after_or_equal' => 'The :attribute tarihinden sonraki yada ona eşit bir tarih olmalıdır.',
    'alpha' => 'The attribute yalnızca harf içerebilir.',
    'alpha_dash' => 'The :attribute yalnızca harf, sayı,tire ve alt çizgi içerebilir.',
    'alpha_num' => 'The :attribute yalnızca harf ve rakam içerebilir.',
    'array' => 'The :attribute bir dizi olmalıdır.',
    'before' => 'The :attribute tarih öncesi olmalıdır :date.',
    'before_or_equal' => 'The :attribute tarihinden önce veya : tarihi arasında olmalıdır.',
    '' => [
        'numeric' => 'The :attribute minimum : maksimum: arasında olmalıdır.',
        'file' => 'The :attribute minimum :ve maksimum :arasında olmalıdır.',
        'string' => 'The :attribute minimum : ve maksimum:arasında olmalıdır.',
        'array' => 'The :attribute minimum : ve maksimum: öğeler arasında olmalıdır.',
    ],
    'boolean' => 'The :attribute alan doğru veya yanlış olmalıdır.',
    'confirmed' => 'The :attribute onay uyuşmuyor.',
    'date' => 'The :attribute geçerli bir tarih değil.',
    'date_equals' => 'The :attribute : tarihine eşit bir tarih olmalıdır.',
    'date_format' => 'The :attribute format :formatı ile eşleşmiyor.',
    'different' => 'The :attribute ve diğeri : farklı olmalıdır.',
    'digits' => 'The :attribute : basamak basamak olmalıdır.',
    'digits_between' => 'The :attribute minimum ve maksimum :basamak arasında olmalıdır.',
    'dimensions' => 'The :attribute geçersiz resim boyutları var.',
    'distinct' => 'The :attribute alanın yinelenen bir değeri var.',
    'email' => 'The :attribute geçerli bie e-posta adresi olmalıdır.',
    'ends_with' => 'The :attribute aşağıdaki şu değerlerden biri ile bitmelidir :',
    'exists' => 'The seçilen : geçerli değil.',
    'file' => 'The :attribute bir dosya olmalıdır.',
    'filled' => 'The :attribute alanın bir değeri olmalıdır.',
    'gt' => [
        'numeric' => 'The :attribute şu değerden büyük olmalıdır.Değer:.',
        'file' => 'The :attribute Kb değerinden büyük olmalıdır.',
        'string' => 'The :attribute : karakter değerindenden büyük olmalıdır.',
        'array' => 'The :attribute : öğesinden daha fazlasına sahip olmalıdır.',
    ],
    'gte' => [
        'numeric' => 'The :attribute :den büyük veya eşit bir değer olmalıdır.',
        'file' => 'The :attribute : e eşit veya daha büyük bir değer olmalıdır.',
        'string' => 'The :attribute : den büyük veya eşit değerde olmalıdır.',
        'array' => 'The :attribute öğelerin değeri : yada daha fazlası olmalıdır.',
    ],
    'image' => 'The :attribute bir görüntü olmalıdır.',
    'in' => 'The selected :attribute geçersizdir
	.',
    'in_array' => 'The :attribute alanı şu alanda mevcut değil.',
    'integer' => 'The :attribute tam sayı olmak zorunda.',
    'ip' => 'The :attribute geçerli bir IP adresi olmak zorunda.',
    'ipv4' => 'The :attribute geçerli bir IPv4 adresi olamak zorunda.',
    'ipv6' => 'The :attribute geçerli bir IPv6 adresiolmakzorunda.',
    'json' => 'The :attribute geçerli bir JSON dizesi olmalıdır.',
    'lt' => [
        'numeric' => 'The :attribute : değerden küçük olmalıdır.',
        'file' => 'The :attribute kb değeri :den küçük olmalıdır.',
        'string' => 'The :attribute karakter değerleri : den küçük olmalıdır.',
        'array' => 'The :attribute öğe değerleri : den daha az olmalıdır.',
    ],
    'lte' => [
        'numeric' => 'The :attribute değer :e eşit veya daha küçük olmalıdır.',
        'file' => 'The :attribute Kb değeri :e eşit veya daha büyük olmalıdır.',
        'string' => 'The :attribute karakter değeri :den küçük veya eşit olmalıdır.',
        'array' => 'The :attribute öğe değerleri : den daha fazla olmamalıdır.',
    ],
    'max' => [
        'numeric' => 'The :attribute den fazla olamaz maksimum:.',
        'file' => 'The :attribute :den büyük olamaz maksimum : kb.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute maksimum karakter :den fazla olamaz.',
    ],
    'mimes' => 'The :attribute değerler : türünden dosyalar olmalıdır.',
    'mimetypes' => 'The :attribute değerler : türünden dosyalar olmalıdır.',
    'min' => [
        'numeric' => 'The :attribute en az : olmalı.',
        'file' => 'The :attribute minimum : Kb olmalı.',
        'string' => 'The :attribute en az : karakter olmalı.',
        'array' => 'The :attribute ez az : öğe olamalı.',
    ],
    'not_in' => 'The selected :attribute geçersizdir.',
    'not_regex' => 'The :attribute format geçersizdir.',
    'numeric' => 'The :attribute bir sayı olmalı.',
    'present' => 'The :attribute alan mevcut olmalı.',
    'regex' => 'The :attribute format geçersiz.',
    'required' => 'The :attribute alan gerekli.',
    'required_if' => 'The :attribute alan şu durumlarda gereklidir.',
    'required_unless' => 'The :attribute alan zorunlu değilse.',
    'required_with' => 'The :attribute değerler mevcut ise alan şu durumlarda gereklidir:',
    'required_with_all' => 'The :attribute  bu alan şu değerler mevcutsa gereklidir :.',
    'required_without' => 'The :attribute bu alan şu değerler mevcut değil ise gereklidir.',
    'required_without_all' => 'The :attribute değererin hiçbiri olmadığında bu alan zorunludur.',
    'same' => 'The :attribute ve :diğerleri eşleşmelidir.',
    'boyut' => [
        'numeric' => 'The :attribute boyut : olmalıdır.',
        'file' => 'The :attribute boyut : kb olmalıdır.',
        'string' => 'The :attribute karakter boyutu : olmalıdır.',
        'array' => 'The :attribute :boyutunda öğeler içermelidir.',
    ],
    'starts_with' => 'The :attribute değerler aşağıdakilerden biriyle başlamalıdır',
    'string' => 'The :attribute bir dize olmalı.',
    'timezone' => 'The :attribute geçerli bir bölge olmalı.',
    'unique' => 'The :attribute daha önce alındı.',
    'uploaded' => 'The :attribute yüklenemedi.',
    'url' => 'The :attribute geçersiz format.',
    'uuid' => 'The :attribute geçerli bir  UUID olmalı.',

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
