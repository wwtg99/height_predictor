<template>
    <div class="container">
        <div class="flex_box bg_light" id="genotypes">
            <h2 class="title">基于基因型的身高预测</h2>
            <div class="content">
                <genotype-predictor></genotype-predictor>
            </div>
            <div class="content text-center">
                <a href="#parents">没有基因型，试试用父母的身高预测？</a>
            </div>
        </div>
        <div class="flex_box bg_light_blue" id="parents">
            <h2 class="title">基于父母的身高预测</h2>
            <div class="content">
                <parent-predictor></parent-predictor>
            </div>
            <div class="content text-center">
                <a href="#genotypes">我有基因型，给我测测遗传身高。</a>
            </div>
        </div>
        <BackTop></BackTop>
        <footer>
            <div class="foot_row bg_blue">
                <Row>
                    <Col span="6" offset="3">
                        <h4><Icon type="social-github"></Icon> GitHub</h4>
                        <ul>
                            <li><a href="#" target="_blank">Predict height scripts</a></li>
                            <li><a href="#" target="_blank">Height predictor server</a></li>
                        </ul>
                    </Col>
                    <Col span="6">
                        <h4><Icon type="link"></Icon> 相关链接</h4>
                        <ul>
                            <li><a href="#" target="_blank">关于我</a></li>
                            <li><a href="#" target="_blank">联系我</a></li>
                        </ul>
                    </Col>
                    <Col span="6">
                        <h4><Icon type="chatboxes"></Icon> About me</h4>
                        <ul>
                            <li><a href="#" target="_blank">关于我</a></li>
                            <li><a href="#" target="_blank">联系我</a></li>
                        </ul>
                    </Col>
                </Row>
            </div>
            <div class="foot_row bg_dark_blue text-center">
                aaaa
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>
    .flex_box {
        width: 100%;
        min-height: 100vh;
        min-width: 600px;
        display: -webkit-flex;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }
    .text-center {
        text-align: center;
    }
    .bg_light {
        background-color: #F6F6F6;
    }
    .bg_light_blue {
        background-color: #D6E4F0;
    }
    .bg_blue {
        background-color: #1E56A0;
    }
    .bg_dark_blue {
        background-color: #163172;
    }
    h2.title {
        padding-top: 50px;
    }
    .title {
        font-size: 28px;
        font-weight: 800;
        padding: 20px 10px;
        width: 100%;
        text-align: center;
    }
    .content {
        width: 80%;
        max-width: 500px;
        padding: 20px 50px;
    }
    footer h4 {
        font-size: 14px;
        font-weight: 600;
        padding-top: 30px;
    }
    .foot_row {
        width: 100%;
        color: #d5d5d5;
    }
    footer ul {
        list-style: none;
        padding: 10px 0;
    }
    footer ul li {
        padding: 5px 0;
    }
    footer ul li>a {
        text-decoration: none;
        color: #c0c0c0;
    }
</style>
