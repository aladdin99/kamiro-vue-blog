阿里妈妈中采用symbol方式引入(使用及更新方式)
1、添加需要的图标到购物车，接着将其成一个项目
2、选择symbol并下载项目到本地
3、打开压缩包将其中的'iconfont.js'引入到此处

在'components'组件中定义一个图标组件'icon-components.vue' 方便后面页面的引入及使用
在'main.js'中引入定义好的图标组件，引入方式如下：
import IconSvg from './components/icon-components';
Vue.component('icon-svg', IconSvg)

页面中引用实例：
<icon-svg icon-class="icon-dianzan"/>