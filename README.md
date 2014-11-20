### 项目的部署注意

1. 使用apache服务器是需要开启rewrite模块。
2. 网站的根目录为www目录。
3. PHP最好使用5.3或以上版本。
4. 数据库配置文件存放在database目录中，需要拷贝一份至application/config目录中。
5. 需要自动加载database类库，可以在config/autoload.php中配置

