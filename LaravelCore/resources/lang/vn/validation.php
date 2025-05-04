<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Những dòng ngôn ngữ dưới đây chứa các thông báo lỗi mặc định được sử dụng bởi
    | lớp validator. Một số quy tắc này có nhiều phiên bản khác nhau như
    | các quy tắc kích thước. Bạn có thể điều chỉnh mỗi thông báo ở đây.
    |
    */

    'accepted' => ':attribute phải được chấp nhận.',
    'active_url' => ':attribute không phải là URL hợp lệ.',
    'after' => ':attribute phải là ngày sau :date.',
    'after_or_equal' => ':attribute phải là ngày sau hoặc bằng :date.',
    'alpha' => ':attribute chỉ có thể chứa chữ cái.',
    'alpha_dash' => ':attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
    'alpha_num' => ':attribute chỉ có thể chứa chữ cái và số.',
    'array' => ':attribute phải là mảng.',
    'before' => 'Phải là ngày trước :date.',
    'before_or_equal' => ':attribute phải là ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => ':attribute phải nằm giữa :min và :max.',
        'file' => ':attribute phải nằm giữa :min và :max kilobytes.',
        'string' => ':attribute phải nằm giữa :min và :max ký tự.',
        'array' => ':attribute phải có từ :min đến :max phần tử.',
    ],
    'boolean' => ':attribute phải là true hoặc false.',
    'confirmed' => 'Mật khẩu xác nhận không khớp.',
    'date' => ':attribute không phải là ngày hợp lệ.',
    'date_equals' => ':attribute phải là ngày bằng :date.',
    'date_format' => ':attribute không khớp với định dạng :format.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => 'Số lượng ký tự không đúng.',
    'digits_between' => ':attribute phải từ :min đến :max chữ số.',
    'dimensions' => ':attribute có kích thước ảnh không hợp lệ.',
    'distinct' => ':attribute có giá trị trùng lặp.',
    'email' => ':attribute phải là địa chỉ email hợp lệ.',
    'ends_with' => ':attribute phải kết thúc bằng một trong những giá trị sau: :values.',
    'exists' => ':attribute đã chọn không hợp lệ.',
    'file' => ':attribute phải là một tập tin.',
    'filled' => ':attribute phải có một giá trị.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'string' => ':attribute phải nhiều hơn :value ký tự.',
        'array' => ':attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải lớn hơn hoặc bằng :value ký tự.',
        'array' => ':attribute phải có :value phần tử hoặc nhiều hơn.',
    ],
    'image' => ':attribute phải là hình ảnh.',
    'in' => ':attribute đã chọn không hợp lệ.',
    'in_array' => ':attribute không tồn tại trong :other.',
    'integer' => ':attribute phải là số nguyên.',
    'ip' => ':attribute phải là địa chỉ IP hợp lệ.',
    'ipv4' => ':attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6' => ':attribute phải là địa chỉ IPv6 hợp lệ.',
    'json' => ':attribute phải là chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file' => ':attribute phải nhỏ hơn :value kilobytes.',
        'string' => ':attribute phải ít hơn :value ký tự.',
        'array' => ':attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải ít hơn hoặc bằng :value ký tự.',
        'array' => ':attribute không được có nhiều hơn :value phần tử.',
    ],
    'max' => [
        'numeric' => ':attribute có thể không lớn hơn :max.',
        'file' => ':attribute có thể không lớn hơn :max kilobytes.',
        'string' => ':attribute có thể không lớn hơn :max ký tự.',
        'array' => ':attribute có thể không có nhiều hơn :max phần tử.',
    ],
    'mimes' => ':attribute phải là một tập tin loại: :values.',
    'mimetypes' => ':attribute phải là một tập tin loại: :values.',
    'min' => [
        'numeric' => ':attribute phải ít nhất là :min.',
        'file' => ':attribute phải ít nhất :min kilobytes.',
        'string' => ':attribute phải ít nhất :min ký tự.',
        'array' => ':attribute phải có ít nhất :min phần tử.',
    ],
    'not_in' => ':attribute đã chọn không hợp lệ.',
    'not_regex' => 'Định dạng của :attribute không hợp lệ.',
    'numeric' => 'Vui lòng chỉ nhập số.',
    'password' => 'Mật khẩu không đúng.',
    'present' => ':attribute không thể để trống.',
    'regex' => 'Định dạng của :attribute không hợp lệ.',
    'required' => ':attribute không thể để trống.',
    'required_if' => ':attribute không thể để trống khi :other là :value.',
    'required_unless' => ':attribute không thể để trống trừ khi :other có trong :values.',
    'required_with' => ':attribute không thể để trống khi :values có mặt.',
    'required_with_all' => ':attribute không thể để trống khi :values có mặt.',
    'required_without' => ':attribute không thể để trống khi :values không có mặt.',
    'required_without_all' => ':attribute không thể để trống khi không có bất kỳ :values nào có mặt.',
    'same' => ':attribute và :other phải khớp nhau.',
    'size' => [
        'numeric' => ':attribute phải là :size.',
        'file' => ':attribute phải là :size kilobytes.',
        'string' => ':attribute phải là :size ký tự.',
        'array' => ':attribute phải chứa :size phần tử.',
    ],
    'starts_with' => ':attribute phải bắt đầu bằng một trong những giá trị sau: :values.',
    'string' => ':attribute phải là một chuỗi.',
    'timezone' => ':attribute phải là một múi giờ hợp lệ.',
    'unique' => ':attribute đã được sử dụng.',
    'uploaded' => ':attribute tải lên thất bại.',
    'url' => ':attribute không đúng định dạng.',
    'uuid' => ':attribute phải là UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Ở đây, bạn có thể chỉ định các thông báo tùy chỉnh cho các thuộc tính sử dụng
    | quy tắc "attribute.rule" để đặt tên các dòng ngôn ngữ. Điều này giúp cho
    | việc chỉ định một dòng ngôn ngữ tùy chỉnh cụ thể cho một quy tắc thuộc tính.
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
    | Những dòng ngôn ngữ dưới đây được sử dụng để đổi placeholder thuộc tính của chúng ta
    | thành một cái gì đó thân thiện hơn với người đọc như "Địa chỉ Email" thay vì
    | "email". Điều này đơn giản là giúp chúng ta làm cho thông báo của mình thêm phong phú.
    |
    */

    'attributes' => [],

];
