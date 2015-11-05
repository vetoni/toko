<?php

namespace app\modules\install\demo;

use app\models\Category;
use app\models\Page;
use app\models\Product;
use app\modules\user\models\User;
use Yii;

/**
 * Class DemoData
 * @package app\modules\install\demo
 */
class DemoData
{
    /**
     * @param $params
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function create($params)
    {
        $language = substr(Yii::$app->language, 0, 2);
        $db = Yii::$app->getDb();

        // Currencies
        $db->createCommand()->batchInsert('{{%currency}}', ['code', 'name', 'is_default', 'rate', 'symbol'], [
            ['EUR', 'Euro', 0, 0.0145, '€'],
            ['UAH', 'Hryvnia', 0, 0.3601, '₴'],
            ['RUB', 'Ruble', 1, 1, '₽'],
            ['USD', 'US Dollar', 0, 0.0158, '$'],
        ])->execute();

        // Countries
        $countries = "countries_{$language}";
        static::$countries($db);

        // Users
        $root_auth_key = Yii::$app->security->generateRandomString();
        $root_password = Yii::$app->security->generatePasswordHash($params['admin_password']);
        $user = new User([
            'email' => 'admin.toko-webshop@gmail.com',
            'name' => 'admin',
            'country_id' => 'us',
            'address' => '7805 Southcrest Parkway, Southaven, MS(Mississippi) 38671',
            'phone' => '(662) 349-7500',
            'password_hash' => $root_password,
            'auth_key' => $root_auth_key,
            'role' => User::USER_ROLE_ADMIN
        ]);
        $user->save();

        // Categories
        $categories = "categories_{$language}";
        static::$categories();

        // Products
        $products = "products_{$language}";
        static::$products();

        // Pages
        $pages = "pages_{$language}";
        static::$pages();

        // Relations
        $db->createCommand()->batchInsert('{{%relation}}', ['item_id', 'related_id', 'model'], [
            [1, 2, 'Product'],
            [1, 3, 'Product'],
            [3, 1, 'Product'],
            [3, 2, 'Product'],
        ])->execute();
    }

    public static function countries_en()
    {
        $db = Yii::$app->getDb();
        $db->createCommand()->batchInsert('{{%country}}',
            ['id', 'name', 'currency_code'],
            [
                ['ru', 'Russia', 'RUB'],
                ['ua', 'Ukraine', 'UAH'],
                ['uk', 'United Kingdom', 'EUR'],
                ['us', 'United States', 'USD'],
            ]
        )->execute();
    }

    public static function categories_en()
    {
        static::buildCategoryTree([
            [
                'name' => 'Laptops & PCs',
                'nodes' => [
                    ['name' => 'Desktop PCs'],
                    ['name' => 'Laptops'],
                    ['name' => 'Tablets'],
                ]
            ],
            [
                'name' => 'Accessories',
                'nodes' => [
                    ['name' => 'Mice'],
                    ['name' => 'Keyboards'],
                    ['name' => 'Monitors'],
                    ['name' => 'Speakers'],
                ]
            ],
            [
                'name' => 'Computer hardware',
                'nodes' => [
                    [
                        'name' => 'Computer components',
                        'nodes' => [
                            ['name' => 'CPUs / Processors'],
                            ['name' => 'Motherboards'],
                            ['name' => 'Video Cards & Devices'],
                        ]
                    ],
                    [
                        'name' => 'Storage devices',
                        'nodes' => [
                            ['name' => 'Internal Hard Drives'],
                            ['name' => 'SSDs'],
                            ['name' => 'External Hard Drives'],
                        ]
                    ],
                    [
                        'name' => 'Networking',
                        'nodes' => [
                            ['name' => 'Wireless Networking'],
                            ['name' => 'Routers'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Gaming',
                'nodes' => [
                    ['name' => 'Xbox One'],
                    ['name' => 'PlayStation 4'],
                    ['name' => 'PS Vita'],
                ]
            ],
        ]);
    }

    public static function products_en()
    {
        static::saveProducts([
            [
                'category_id' => '2',
                'name' => 'LENOVO H30 Desktop PC',
                'announce' => '<ul><li>Windows</li><li>AMD A8-6410 APU</li><li>Memory: 8 GB</li><li>Hard drive: 1 TB</li><li>With built-in WiFi</li></ul>',
                'description' => '<p>A space saving design and reliable AMD processing makes the Lenovo <strong>H30 Desktop PC</strong> a great choice for everyday computing.<strong></strong></p><p><strong>Windows 10</strong><br> <br> If you\'re an experienced Windows user you\'ll be pleased with the return of the familiar Start button and menu, while everyone will benefit from the many new and exciting features designed to make accessing what matters to you quick and easy.<br> Windows 10 features the new Edge browser, which gives you a much bigger viewing area for enjoying your online content at its best. You can write notes directly onto web pages and share them with anyone - perfect for students or business.<br> Working between different software or keeping an eye on social media while you work has never been easier; you can now snap up to four apps to any location on the screen for effortless multitasking. You can even create individual desktops for specific projects and tasks.<br> Whatever you\'re doing, Windows 10 makes your PC work the way you want.<strong><br> <br> <strong>Reliable computing</strong></strong><br> <br> Enjoy fast and reliable computing, from essays and project work to socialising with friends and browsing the web with the AMD A8-6410 quad-core processor.<br>Supported by 8 GB of RAM, you\'ll be able to effortlessly multitask and run applications such as photo editing software, or play games.</p>',
                'old_price' => 22200.00,
                'price' => 30000.00,
                'inventory' => 50
            ],
            [
                'category_id' => '2',
                'name' => 'HP Pavilion 23-q055na Touchscreen All-in-One PC',
                'announce' => '<ul><li>Windows</li><li>Intel® Core™ i5-4460T Processor</li><li>Memory: 8 GB</li><li>Hard drive: 1 TB</li><li>With built-in WiFi</li></ul>',
                'description' => '<p>Beautifully engineered and complete with a stylish aluminium-coated stand, the HP<strong> Pavilion 23-q055na Touchscreen All-in-One PC </strong>delivers powerful, good-looking computing every day.<strong></strong></p><p><br><strong></strong></p><p><strong>Intel® Core™ i-5 processor</strong></p><p>Powered by the Intel® Core™ i5-4460T quad-core processor and offering 8 GB of RAM, the <strong>23-q055na </strong>delivers advanced multi-tasking to bring your productivity to the next level. Whether you\'re browsing the web, streaming the latest blockbuster or working with more demanding software, the <strong>23-q055na </strong>has got you covered. Ideal for home computing, you can switch between applications quickly and easily without worrying about your computer slowing you down.<strong></strong></p><p><br><strong></strong></p><p><strong>Edge-to-edge entertainment</strong></p><p>The <strong>23-q055na Touchscreen</strong> boasts a 23” edge-to-edge glass IPS display to bring your movies and entertainment to life. With a Full HD screen you can enjoy all your favourite films and TV shows in amazing cinematic-quality.<strong></strong></p><p><br><strong></strong></p><p><strong>HP Connected Music</strong></p><p>Enjoy unlimited access to radio playlists for 12 months with HP Connected Music, absolutely free. Listen to the latest tracks, ad-free and even be in with a chance to win concert tickets to your favourite artists.<strong></strong></p><p><br><strong></strong></p><p><strong>Windows 10</strong><br> <br> If you\'re an experienced Windows user you\'ll be pleased with the return of the familiar Start button and menu, while everyone will benefit from the many new and exciting features designed to make accessing what matters to you quick and easy.<br> </p><p>Windows 10 features the new Edge browser, which gives you a much bigger viewing area for enjoying your online content at its best. You can write notes directly onto web pages and share them with anyone - perfect for students or business.<br> </p><p>Working between different software or keeping an eye on social media while you work has never been easier; you can now snap up to four apps to any location on the screen for effortless multitasking. You can even create individual desktops for specific projects and tasks.<br> </p><p>Whatever you\'re doing, Windows 10 makes your PC work the way you want.</p><p><br><strong>How to upgrade to Windows 10</strong><strong><br> <br> </strong>Installing your free upgrade is easy. Simply select the option to upgrade when you first switch on your PC. If you\'d rather try out Windows 8.1 first, you can choose to upgrade at a later date by clicking the Windows icon in the tool bar at the bottom right of the screen.<br> If you\'d rather not do it yourself, our Knowhow experts in store can set your PC up for you.</p><p>Slim and sleek, lead the way with premium entertainment and multi-tasking with the HP<strong> Pavilion 23-q055na Touchscreen All-in-One PC</strong>.<strong></strong></p><p>___________________________________________________________________________<br> Ultrabook, Celeron, Celeron Inside, Core Inside, Intel, Intel Logo, Intel Atom, Intel Atom Inside, Intel Core, Intel Inside, Intel Inside Logo, Intel vPro, Itanium, Itanium Inside, Pentium, Pentium Inside, vPro Inside, Xeon, and Xeon Inside are trademarks of Intel Corporation in the U.S. and/or other countries.</p>',
                'old_price' => 36500.00,
                'price' => 38000.00,
                'inventory' => 10
            ],
            [
                'category_id' => '2',
                'name' => 'LENOVO IdeaCentre AIO 700 23.8" Touchscreen',
                'announce' => '<ul><li>Intel® RealSense™ 3D camera</li><li>Windows 10 (pre-installed)</li><li>Intel® Core™ i5-6400 Processor</li><li>Graphics: NVIDIA GeForce GT 930</li><li>Hard drive: 2 TB</li></ul>',
                'description' => '<p>Enjoy fast computing with stunning images with the Lenovo<strong> IdeaCentre</strong> <strong>AIO 700 23.8" Touchscreen All-in-One PC</strong>. <br> <strong><strong><br>Powerful all-in-one computing</strong></strong><br> <br> The combination of a 6th generation, quad-core Intel® Core™ i5 Processor and NVIDIA graphics provide you with an impressive performance and stunning visuals to suit everything from everyday computing to serious creative projects. </p><p><br>Work faster and smarter than ever with Intel® Turbo Boost technology, which gives you a boost in processing speed whenever you need it. From photo editing to researching an essay, you can expect the performance you need to work and create at your best. <br> <br> There\'s plenty of room to store all of your favourite music, pictures and videos thanks to a huge 2TB of storage. Backing it all up is easy thanks to USB 3.0, which makes light work of transferring even the largest documents to external hard drives.<strong><br> <br> <strong>Intel® RealSense™ camera </strong><br> <br> </strong>The<strong> <strong>IdeaCentre</strong> 700 </strong>features an Intel® RealSense™. This advanced technology works through the webcam and lets you navigate and select options completely hands free. From skipping songs with a quick wave to everyday navigation with messy hands, it makes everyday computing fast, fun and intuitive.<br> <br> You can even use the RealSense™ camera to scan objects and people in 3D, take photos with accurate measurements displayed, refocus photos after they\'ve been taken and much more.<strong><br> <br> <strong>Visuals and sound</strong></strong><br> <br> Expect impressive images thanks to the Full HD touchscreen. The 1080p screen resolution is up there with many of the latest HD TVs, so you can use the <strong>AIO 700 </strong>for streaming films and TV without sacrificing image quality - ideal if you\'ve been turfed out of the living room for the soaps or sport. <strong><br> <br> <strong>Touchscreen control</strong></strong><br> <br> Navigating documents, the web and software has never been easier than with touchscreen control. Simply touch, swipe and pinch the screen to navigate your PC with the same gestures you\'d use on a tablet or smartphone. Whether you\'re using the <strong>AIO 700 </strong>for playing games with the family, writing an essay or chatting to friends, you\'ll benefit from faster and more intuitive control.<strong><br> <br> <strong>Comfort is key</strong></strong><br> <br> Type for longer in comfort thanks to the AccuType keyboard, which features finger-friendly keys. <br> <br> The attractive metal V-shape stand allows you to adjust the screen to suit you, so you can find the ideal position in any room. <br> <br> <strong>Preinstalled with Windows 10</strong><br> <br> If you\'re an experienced Windows user you\'ll be pleased with the return of the familiar Start button and menu, while everyone will benefit from the many new and exciting features designed to make accessing what matters to you quick and easy.<br> <br> Windows 10 features the new Edge browser, which gives you a much bigger viewing area for enjoying your online content at its best. You can write notes directly onto web pages and share them with anyone - perfect for students or business.</p><p><br>___________________________________________________________________________<br> Ultrabook, Celeron, Celeron Inside, Core Inside, Intel, Intel Logo, Intel Atom, Intel Atom Inside, Intel Core, Intel Inside, Intel Inside Logo, Intel vPro, Itanium, Itanium Inside, Pentium, Pentium Inside, vPro Inside, Xeon, and Xeon Inside are trademarks of Intel Corporation in the U.S. and/or other countries.</p>',
                'price' => 54400.00,
                'inventory' => 25
            ],

        ]);
    }

    public static function pages_en()
    {
        static::savePages([
            [
                'name' => 'Shop by category',
                'type' => 'list',
                'announce' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br>Sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
                'is_system' => 1,
            ],
        ]);
    }

    /**
     * @param $list
     */
    protected static function savePages($list)
    {
        foreach($list as $item) {
            $page = new Page($item);
            $page->save();
            $page->attachImage( __DIR__ . '/images/pages/' . $page->id. '.jpg');
        }
    }

    /**
     * @param $list
     */
    protected static function saveProducts($list)
    {
        foreach($list as $item) {
            $product = new Product($item);
            $product->save();
            $pattern = __DIR__ . '/images/products/' . $product->id. '_*.jpg';

            foreach (glob($pattern) as $fileName) {
                $product->attachImage($fileName);
            }
        }
    }

    /**
     * @param $nodes
     * @param null $parent
     */
    protected static function buildCategoryTree($nodes, $parent = null)
    {
        foreach ($nodes as $node)
        {
            $category = new Category([
                'name' => $node['name'],
                'announce' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br>Sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.'
            ]);
            if ($parent === null) {
                $category->makeRoot();
            }
            else {
                $category->appendTo($parent);
            }
            $category->attachImage(__DIR__ . '/images/categories/' . $category->id . '.jpg');
            if (isset($node['nodes'])) {
                self::buildCategoryTree($node['nodes'], $category);
            }
        }
    }
}