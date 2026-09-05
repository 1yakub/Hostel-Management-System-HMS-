<?php

// Demo content for the public site. One place to rename the fictional hostel.
return [
    'hostel_name' => env('HMS_HOSTEL_NAME', 'Copperline Hostel'),
    'tagline' => env('HMS_TAGLINE', 'A small city hostel with a big kitchen table.'),
    'address_line' => env('HMS_ADDRESS', '14 Copperline Lane, Old Town'),
    'city' => env('HMS_CITY', 'Dhaka'),
    'phone' => env('HMS_PHONE', '+880 1700 000000'),
    'email' => env('HMS_EMAIL', 'hello@example.com'),
    'check_in' => env('HMS_CHECK_IN', '2:00 PM'),
    'check_out' => env('HMS_CHECK_OUT', '11:00 AM'),
    'currency' => env('HMS_CURRENCY', 'USD'),
    'currency_symbol' => env('HMS_CURRENCY_SYMBOL', '$'),
    'demo_mode' => env('HMS_DEMO_MODE', true),

    // Questions the FAQ section shows and the assistant may answer from. Plain facts only.
    'faq' => [
        ['q' => 'What time is check in and check out?', 'a' => 'Check in opens at 2:00 PM and check out is by 11:00 AM. Early bag drop is free from 9:00 AM.'],
        ['q' => 'Do you have private rooms?', 'a' => 'Yes. Private doubles and one family room, next to the shared dorms. Every room has a lockable door and a window.'],
        ['q' => 'Is breakfast included?', 'a' => 'A simple breakfast in the courtyard cafe is included with every bed: bread, eggs, fruit, tea and coffee, from 7:30 to 10:00 AM.'],
        ['q' => 'How do I pay?', 'a' => 'A booking request holds your bed. You pay at the desk on arrival, by card or cash. Nothing is charged online.'],
        ['q' => 'Can I cancel?', 'a' => 'Yes, free of charge up to 48 hours before check in. Tell us by email or phone and we release the bed.'],
        ['q' => 'Are there lockers and Wi-Fi?', 'a' => 'Every bed has a lockable drawer and a reading light. Wi-Fi is free through the whole building, including the courtyard.'],
        ['q' => 'How do I get there from the airport?', 'a' => 'A ride share takes about 45 minutes outside rush hour. Ask us for the pinned location before you land, and we will meet you at the gate.'],
    ],
];
