<?php
return [ 
		'metaHttp' => [ 
				'Content-Type|text\/html; charset=utf-8',
		],
		'metaName' => [ 
				'viewport|width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' 
		],
		'css' => [ 
			'css/reset.css',
			'css/main.css',
			'css/fontawesome.min.css',
			'css/jquery-ui.min.css'
		],
		'js' => [ 
			'js/jquery.min.js',
			'js/jquery-ui.min.js',
			'js/main.min.js'	
		],
		'User' => [ 
				'login'=>[
						'title' => 'Đăng nhập ứng dụng quản lý bán hàng trực tuyến',
						'onlyone'=>[
							'css'=>[
								'css/reset.css',								
								'css/login.css',
								'css/fontawesome.min.css',
							]
						]						
				],
				'list'=>[
					'title' => 'Danh sách tài khoản người dùng'				
				],
				'index'=>[
					'title' => 'Quản lý phân quyền người dùng'
				]
		],
		'Dashboard' => [ 
				'index'=>[
					'title' => 'Tiêu đề của trang xxxx'					
				]
				
		],
		'Bill' => [ 
				'index'=>[
					'title' => 'Quản lý đơn hàng'
				]				
		],
		'Invoice' => [ 
				'collect'=>[
					'title' => 'Quản lý khoản thu'
				],
				'pay'=>[
					'title' => 'Quản lý khoản chi'
				]					
		],
		'Fanpage' => [ 
				'login'=>[
					'title' => 'Đăng nhập facebook'	
				],
				'feed'=>[
					'title' => 'Quản lý bài viết Fanpage'
				],
				'inbox'=>[
					'title' => 'Quản lý tin nhắn và bình luận Fanpage'
				]					
		],
		'Report' => [ 
				'customer'=>[
					'title' => 'Báo cáo khách hàng'
				],
				'customerStatistical'=>[
					'title' => 'thống kê khách hàng'
				],
				'bill'=>[
					'title' => 'Báo cáo đơn hàng'	
				],
				'billStatistical'=>[
					'title' => 'thống kê khách hàng'
				],
				'collect'=>[
					'title' => 'Báo cáo khoản thu'
				],
				'pay'=>[
					'title' => 'Báo cáo khoản chi'
				]					
		],
		'Inventory' => [ 
				'index'=>[
					'title' => 'Quản lý kho bãi'
				]							
		],
		'Import' => [ 
				'index'=>[
					'title' => 'Nhập sản phẩm vào kho hàng'
				]					
		],
		'Setting' => [ 
				'info'=>[
					'title' => 'Cài đặt thông tin cửa hàng',
					'js'=>[
						'../plugins/ckeditor/ckeditor.js'
					]
				],
				'print'=>[
					'title' => 'Cài đặt máy in - mẫu in'					
				],
				'post'=>[
					'title' => 'Cài đặt đơn vị vận chuyển'					
				]				
		],
		'Product' => [ 
				'index'=>[
					'title' => 'Quản lý sản phẩm'					
				]	
		],
		'Error' => [ 
			'index'=>[
				'title' => 'Không tìm thấy trang'			
			],
			'permission'=>[
				'title' => 'Truy cập bị cấm'			
			]					
		] 
];
?>