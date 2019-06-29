<template>
    <div class="sn-nav-panel">
        <div class="sn-brand">
            <img style="width: 100%; height: 100%;" src="/img/logo.svg"/>
        </div>
        <div class="sn-nav">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" id="donate" style="display: none">
                <input type="hidden" name="cmd" value="_donations" />
                <input type="hidden" name="business" value="taylorbroad@gmail.com" />
                <input type="hidden" name="currency_code" value="USD" />
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
            </form>
            <div class="sn-nav-item" onclick="document.getElementById('donate').submit();">
                <div>
                    <i class="material-icons">payment</i>
                    <div>
                        Donate
                    </div>
                </div>
            </div>
            <!--
            <div class="sn-nav-item">
                <div>
                    <i class="material-icons">navigation</i>
                    <div>
                        Flight<br>
                        Plan
                    </div>
                </div>
            </div>
            <div class="sn-nav-item">
                <div>
                    <i class="material-icons">map</i>
                    <div>
                        Charts
                    </div>
                </div>
            </div>
            <div class="sn-nav-item">
                <div>
                    <i class="material-icons">book</i>
                    <div>
                        KB
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
</template>

<script>
    export default {
        name: "SideNavBar"
    }
</script>

<style scoped>
    .sn-nav-item {
        flex: 1;
        text-align: center;
        line-height: 1;
        max-width: 60px;
        padding-bottom: .5rem;
        color: white;
        border: none;
        background: transparent;
        text-decoration: none;
        text-underline: none;
        transition: .2s;
        margin: .5rem 0;
    }
    .sn-nav-item:hover {
        background: #ffcc00;
        transition: .2s;
        color: white;
        border: none;
        text-decoration: none;
        text-underline: none;
        cursor: pointer;
    }
    .sn-nav-item {
        width: 100%;
        padding: .25rem auto;
    }
    .sn-nav-panel {
        float: left;
        width: 60px;
        height: 100vh;
    }
    .sn-brand {
        height: 60px;
        background: #1a1a1a;
    }
    .sn-nav {
        flex-flow: row wrap;
        flex-wrap: wrap;
    }
</style>
