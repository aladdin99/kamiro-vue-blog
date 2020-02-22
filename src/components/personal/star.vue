<template>
    <div class="star">
        <div class="bannerTop">
            <span>我的粉丝</span>
            <span>共3人</span>
        </div>
        <ul style="list-style: none;line-height:7rem;">
            <li v-for="item in 3" :key="item" style="display: flex;width: 100%;height: 100%;justify-content: space-between;align-items: center;border-bottom: 1px solid #e0e0e0;">
                <div style="display: flex;align-items: center;">
                    <span style="display:inline-block;width: 5rem;height: 5rem;border-radius: 50%;background-color: #FDE0EC;margin-right: 1.5rem;cursor: pointer;"></span>
                    <span style="font-size: 1.6rem;color: #4D4D4D;cursor: pointer;">小女王♛</span>
                </div>
                <span style="border: 1px solid #CA0C16;color:#CA0C16;font-size: 1.4rem;display: inline-block;text-align: center;line-height: normal;padding: .6rem 0;width:8rem;border-radius: .5rem;cursor: pointer;margin-right: 1rem;">关注</span>
            </li>
        </ul>
    </div>
</template>

<style lang="less">
    .star{display: inline-block;width: 65vw;padding-right: 5rem;padding-left:2em;
        .bannerTop{font-size: 2rem;color: #3d3d3d;line-height: 9rem;border-bottom: 1px solid #e0e0e0;font-weight: bold;display: flex;justify-content: space-between;
            span:nth-child(2){font-size: 1.4rem;color: #4d4d4d;font-weight: normal;margin-right: 1.5rem;}
        }
    }
</style>