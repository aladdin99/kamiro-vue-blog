<template>
    <div class="updateAccount">
        <div class="banner_account">
            <div>
                <span>65</span>
                <span style="font-size: 1.4rem;">账号评分安全</span>
            </div>
        </div>
        <ul class="items_account">
            <li>
                <span>绑定邮箱</span>
                <span>未绑定邮箱</span>
                <span>绑定邮箱</span>
            </li>
            <li>
                <span>实名认证</span>
                <span>未完成实名认证</span>
                <span>实名认证</span>
            </li>
            <li>
                <span>设置密码</span>
                <span>已设置</span>
                <span>修改密码</span>
            </li>
            <li>
                <span>绑定手机</span>
                <span>未绑定手机号码</span>
                <span>更换手机</span>
            </li>
            <li>
                <span>绑定QQ账号</span>
                <span>已授权绑定QQ号</span>
                <span>解除绑定</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {

        }
    }
}
</script>

<style lang="less">
.updateAccount{
    height: 100%;
    /*background-color: #343536;*/
}
.banner_account{
    display: flex;height: 15rem;align-items: center;justify-content: center;
    background: url("../../assets/updateAccount.png") no-repeat center top;
    background-size: 29% 100%;
    div{display: flex;flex-direction: column;font-size: 3rem;color: #fff;}
}
    .items_account{display: inline-block;width: 100%;padding: 2rem;box-sizing: border-box;
        li{display: flex;width: 100%;justify-content: space-between;padding: 2rem;box-sizing: border-box;border-top: 1px solid #eff1f5;
            span{flex: 1;}
            span:nth-child(1){text-align: left;}
            span:nth-child(2){color: #6d757a;}
            span:nth-child(3){text-align: right;color: #00b5e5;cursor: pointer;}
        }
    }
</style>