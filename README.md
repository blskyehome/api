Blskye  Api
=============
### 返回错误格式
```json
    {
        "msg": "请求的banner不存在",
        "error_code": 40000,
        "request_url": "/v1/banner/2"
    }
```
### 通用码
-  0  成功  200 201 202
-  10000 通用参数错误400
-  10001 资源未找到 404 
-  10002 未授权（令牌不合法） 401
-  10003 尝试非法操作（自己的令牌操作其他人数据） 403
-  10004 授权失败（第三方应用账号登陆失败）
-  10005 授权失败（服务器缓存异常）
-  10006 base64 转文件 失败  400
-  10007 文件上传失败  400
-  20000 用户不存在
-  30000  权限不够
-  40000 Token已过期或无效Token


### 返回状态说明
-   200	OK	请求成功
-   201	CREATED	创建成功
-   202	ACCEPTED	更新成功
-   400	BAD REQUEST	请求的地址不存在或者包含不支持的参数
-   401	UNAUTHORIZED	未授权
-   403	FORBIDDEN	被禁止访问
-   404	NOT FOUND	请求的资源不存在
-   500	INTERNAL SERVER ERROR	内部错误
### 路由
####    需要token

-   上传头像
    `POST /avatar`
     
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | file         |  dataURL base64     | * |
-   更改用户信息
    `PUT  /user/profile`
       
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | user_name         |  新用户名   |  |
-   创建分类
    `POST /category`
       
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | name         |  分类名   | * |
-   分类查询
    `GET /user/category`
    
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | page         |  页码   |  |
    | size         |  单页条数   |  |
    | keyword         |  关键词   |  |
    | order      |  排序   |  |

-   删除分类
    `DELETE /category/:id`
    
-   修改分类
    `PUT /category/:id`
    
     | 参数          |    含义    | 备注 |
        | ----------    | ---       |-----|
        | name         |  分类名   | * |
-   创建link
    `POST /link`
    
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | openness         |  公开度   | * |
    | category_id         |  用户分类id   | * |
    | title         |  标题   |  |
    | url         |  链接   | * |
    | comment         |  注释   |  |

    
-   获取用户自己的link
    `GET /user/link`
    
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | page         |  页码   |  |
    | size         |  单页条数   |  |
    | keyword         |  关键词   |  |
    | order      |  排序   |  |

-   获取用户某个分类下所有的link
    `GET /user/category/:category_id/link`
    
     | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | page         |  页码   |  |
    | size         |  单页条数   |  |
    | keyword         |  关键词   |  |
    | order      |  排序   |  |

-   用户修改link
    `PUT /link/:id`
    
     | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    |     id     | id    | * |
    | openness         |  公开度   |  |
    | category_id         |  用户分类id   |  |
    | title         |  标题   |  |
    | url         |  链接   |  |
    | comment         |  注释   |  |
-   用户删除link
    `DELETE /link/:id`
-   获取用户信息
    `GET /user`


####    不需要token

-   创建用户
    `POST /user`
    
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | email         |  邮箱      | * |
    | user_name     |  用户名    | * |
    | password      |  密码      | * |
    | captcha       |  验证码    | * |

-   用户获取token
    `POST /token/user`
     
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | user_name         |  邮箱/用户名/手机号      | * |
    | password         |  用户密码      | * |

-   发送验证码
    `POST /user/captcha`
    
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | email         |  邮箱      | * |
    
   
-   更改密码
    `PUT /user/password`
    
    | 参数          |    含义    | 备注 |
    | ----------    | ---       |-----|
    | email         |  邮箱     | * |
    | password      |  新密码      | * |
    | captcha       |  验证码      | * |

-   获取某个用户的公共link
    `GET /user/:user_id/link`
-   获取所有用户的公告link
   `GET /link`
-   获取用户某个分类下公共的link
   `GET /user/:user_id/category/:category_id/link`
-   link点击率
   `PUT /link/:id/clicks`
