<template>
    <div class="container">
        <div class="flex_box bg_pink" id="project">
            <h2 class="title">基于机器学习方法的中国人基因身高预测</h2>
            <div class="abstract">
                <div class="method">
                    <p>使用了机器学习的多种回归模型，对中国人身高相关的 SNP 位点进行学习，从而预测中国人的基因身高。</p>
                </div>
                <div class="link">
                    <Button type="primary" shape="circle" icon="social-github" @click="toGithub">GITHUB</Button>
                    <ul>
                        <li><Button type="text" @click="scrollTo('#genotypes')">我有基因型，给我测测遗传身高。</Button></li>
                        <li><Button type="text" @click="scrollTo('#parents')">没有基因型，试试用父母的身高预测？</Button></li>
                    </ul>
                </div>
                <div class="descr">身高不仅仅由遗传决定，且数据量较少，仅供娱乐 ^_^</div>
            </div>
            <div class="pic"><img src="/assets/height_predictor/images/height.jpg"/></div>
            <div class="note">身高指人体纵向部分的长度。一天内身高的变化，晨起最高，傍晚最低，相差约2厘米。人体身高增长有两个高峰，婴儿时期和青春期。影响身高的因素很多，如遗传、营养、体育运动、良好的睡眠、生活习惯、种族、内分泌、性成熟早晚、远亲婚配等等。遗传因素对身高的影响较大。</div>
        </div>
        <div class="flex_box bg_light_blue" id="introduction">
            <h2 class="title">中国人平均身高</h2>
            <div class="height_img">
                <img src="/assets/height_predictor/images/male.png">
                <img src="/assets/height_predictor/images/female.png">
            </div>
            <div class="height_text">
                <div class="annotation male">成年男性平均身高 <span class="number">167.1</span> cm</div>
                <div class="annotation female">成年女性平均身高 <span class="number">155.8</span> cm</div>
                <div class="ref">数据来源：中国居民营养与慢性病状况报告（2015）</div>
            </div>
        </div>
        <div class="flex_box bg_light" id="genotypes">
            <h2 class="title">基于基因型的身高预测</h2>
            <div class="content">
                <genotype-predictor></genotype-predictor>
            </div>
            <div class="content text-center">
                <Button type="text" @click="scrollTo('#parents')">没有基因型，试试用父母的身高预测？</Button>
            </div>
        </div>
        <div class="flex_box bg_light_blue" id="parents">
            <h2 class="title">基于父母的身高预测</h2>
            <div class="content">
                <parent-predictor></parent-predictor>
            </div>
            <div class="content text-center">
                <Button type="text" @click="scrollTo('#genotypes')">我有基因型，给我测测遗传身高。</Button>
            </div>
        </div>
        <BackTop></BackTop>
        <footer>
            <div class="foot_row bg_blue">
                <Row>
                    <Col span="6" offset="3">
                        <h4><Icon type="social-github"></Icon> GitHub</h4>
                        <ul>
                            <li><a href="https://github.com/wwtg99/predict_height" target="_blank">Predict height scripts</a></li>
                            <li><a href="https://github.com/wwtg99/height_predictor" target="_blank">Height predictor server</a></li>
                        </ul>
                    </Col>
                    <Col span="6">
                        <h4><Icon type="link"></Icon> 相关链接</h4>
                        <ul>
                            <li><a href="http://www.nhfpc.gov.cn/xcs/s3574/201506/6b4c0f873c174ace9f57f11fd4f6f8d9.shtml" target="_blank">中国居民营养与慢性病状况报告</a></li>
                            <li><a href="https://www.ncbi.nlm.nih.gov/pubmed?term=25429064" target="_blank">相关文献1</a></li>
                            <li><a href="https://www.ncbi.nlm.nih.gov/pubmed/?term=23456168" target="_blank">相关文献2</a></li>
                            <li><a href="https://www.ncbi.nlm.nih.gov/pubmed/?term=20189936" target="_blank">相关文献3</a></li>
                            <li><a href="https://www.ncbi.nlm.nih.gov/pubmed/?term=19396169" target="_blank">相关文献4</a></li>
                            <li><a href="https://www.ncbi.nlm.nih.gov/pubmed/?term=28146470" target="_blank">相关文献5</a></li>
                        </ul>
                    </Col>
                    <Col span="6">
                        <h4><Icon type="chatboxes"></Icon> About me</h4>
                        <ul>
                            <li><a href="http://52jing.wang" target="_blank">关于我</a></li>
                        </ul>
                    </Col>
                </Row>
            </div>
            <div class="foot_row bg_dark_blue text-center">
                Copyright © 2017 52jing.wang All Rights Reserved.
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        methods: {
            scrollTo(elem) {
                let curTop = 0;
                let tarTop = document.querySelector(elem).offsetTop;
                if (document.documentElement && document.documentElement.scrollTop) {
                    curTop = document.documentElement.scrollTop;
                } else if (document.body) {
                    curTop = document.body.scrollTop;
                }
                let step = 10;
                if (curTop > tarTop) {
                    step = -10;
                }
                let t = setInterval(function() {
                    if (Math.abs(curTop - tarTop) > Math.abs(step)) {
                        curTop += step;
                        window.scrollTo(0, curTop);
                    } else {
                        clearInterval(t);
                    }
                }, 1);
            },
            toGithub() {
                location.href = 'https://github.com/wwtg99/predict_height';
            }
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
    .bg_pink {
        background-color: #F0E2D9;
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
        font-size: 28px;
        font-weight: 800;
        padding: 20px 10px;
        width: 100%;
        text-align: center;
    }
    .content {
        width: 80%;
        max-width: 600px;
        padding: 20px 50px;
    }
    .abstract {
        width: 60%;
        margin-left: 35%;
        padding: 20px 30px;
        z-index: 3;
    }
    .abstract .method {
        font-size: 18px;
    }
    .abstract .link {
        font-size: 15px;
        padding: 20px 0;
    }
    .abstract .link ul {
        padding: 20px 0;
    }
    .abstract .link ul li {
        padding: 5px 0;
    }
    .abstract .descr {
        font-size: 14px;
    }
    .note {
        background-color: #ffffcc;
        padding: 10px;
        width: 210px;
        position: absolute;
        left: 100px;
        font-size: 13px;
        top: 330px;
        -moz-box-shadow: 5px 5px 7px rgba(33,33,33,1);
        -webkit-box-shadow: 5px 5px 7px rgba(33,33,33,7);
        box-shadow: 5px 5px 7px rgba(33,33,33,7);
        -webkit-transform: rotate(-6deg);
        -moz-transform: rotate(-6deg);
        -o-transform: rotate(-6deg);
        -moz-transition: -moz-transform .15s linear;
        -o-transition: -o-transform .15s linear;
        -webkit-transition: -webkit-transform .15s linear;
        transform: transition .15s linear;
    }
    .note:hover {
        -moz-box-shadow: 10px 10px 7px rgba(0,0,0,7);
        -webkit-box-shadow: 10px 10px 7px rgba(0,0,0,7);
        box-shadow: 10px 10px 7px rgba(0,0,0,7);
        -webkit-transform: scale(1.1);
        -moz-transform: scale(1.1);
        -o-transform: scale(1.1);
        transform: scale(1.1);
        z-index:5;
    }
    .pic {
        position: absolute;
        bottom: -5px;
        right: 0;
        width: 340px;
        z-index: 1;
    }
    .pic img {
        width: 100%;
    }
    .height_img img {
        width: 150px;
    }
    .height_text .annotation {
        display: inline-block;
        padding: 3px;
        font-size: 16px;
        border-bottom: solid 2px #D6E4F0;
        transition: all 0.5s;
        cursor: pointer;
    }
    .height_text .annotation:hover {
        border-bottom: solid 2px #222222;
    }
    .height_text .annotation .number {
        font-size: 18px;
        font-weight: 600;
    }
    .height_text .annotation.male {
        position: relative;
        top: -290px;
        left: -150px;
    }
    .height_text .annotation.female {
        position: relative;
        top: -290px;
        left: 150px;
    }
    .height_text .ref {
        position: absolute;
        right: 50px;
        font-size: 12px;
    }
    /* footer */
    footer h4 {
        font-size: 14px;
        font-weight: 600;
        padding-top: 30px;
    }
    .foot_row {
        width: 100%;
        color: #d5d5d5;
        padding: 5px;
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
