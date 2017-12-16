<template>
    <div class="parent_predictor">
        <Row>
            <Col span="24">
                <Form ref="iform" :model="formItem" :label-width="80" :rules="rules">
                    <Form-item label="父亲身高" prop="father">
                        <Input v-model="formItem.father" placeholder="请输入">
                            <span slot="append">cm</span>
                        </Input>
                    </Form-item>
                    <Form-item label="母亲身高" prop="mother">
                        <Input v-model="formItem.mother" placeholder="请输入">
                            <span slot="append">cm</span>
                        </Input>
                    </Form-item>
                    <Form-item label="性别" prop="gender">
                        <RadioGroup v-model="formItem.gender">
                            <Radio label="male">男</Radio>
                            <Radio label="female">女</Radio>
                        </RadioGroup>
                    </Form-item>
                    <Form-item>
                        <Button type="primary" :loading="loading" @click="submit">提交</Button>
                    </Form-item>
                </Form>
            </Col>
        </Row>
        <transition name="fade">
            <Row v-if="height" class="result">
                <Col span="24">
                    预测孩子身高: <CountUp :start="0" :end="height" :decimals="2" :duration="2.5" class="countup"></CountUp> cm
                </Col>
            </Row>
        </transition>
        <transition name="fade">
            <Row v-if="height" class="tips">
                <Col span="20" offset="2">
                    <div class="title">计算公式如下：</div>
                    <p>男孩成人时身高（CM）＝（父身高 + 母身高）÷2×1.08</p>
                    <p>女孩成人时身高（CM）＝（父身高×0.923 + 母身高）÷2</p>
                    <br>
                    <p>以上公式预测身高有其一定的科学性，从理论上讲，父母的身高决定着子女身高的生长潜力，而潜力能否充分得到发挥，则有赖于良好的外界环境条件。从某种意义上说，外界环境对身高的增长起着重要的作用。作为父母来说，为了孩子的健美，使长高的潜力更好地发挥出来，还必须注意以下几个方面：</p>
                    <div class="title">一、合理营养</div>
                    <p>儿童处于生长发育时期，身体的发育、组织器官的增大都需要大量的养料，其中，尤以蛋白质、碳水化合物、维生素、矿物质和微量元素等更重要。进入青春发育期的孩子要注意营养，多摄取一些动物性食物，并适当吃些蔬菜和水果，纠正偏食和挑食等不良习惯。</p>
                    <div class="title">二、体育锻炼</div>
                    <p>让孩子多参加体育锻炼，尤其是摸高、单杠、游泳、篮球和排球等跳跃性较强的运动，有助于脊椎骨的发育和促进四肢的增长，使人体长得更高。有报道说，对正处于生长发育期的青年来说，如能锲而不舍，持之以恒地锻炼，可使其身高增长3—4厘米，甚至更多。</p>
                    <div class="title">三、疾病治疗</div>
                    <p>对于侏儒症或甲状腺功能不全所致的呆小病，必须从小及时治疗。长期营养不良也会影响身高。据报道，青少年若体内缺铁或发生缺铁性贫血的，其平均身高要比正常青少年低3CM，故缺铁性贫血也应及时治疗。</p>
                    <p>必须指出的是，作为父母，关心孩子的将来身高是很自然的事。但是，我们每个人都应知道，历史和现实中有许多伟人，并非都是八尺身躯的“美男子”。要正视现实，不必为自己的孩子或自己比较矮小而怨天忧人。相反，要让孩子积极锻炼，健康成长。</p>
                </Col>
            </Row>
        </transition>
    </div>
</template>

<script>
    export default {
        name: 'parent_predictor',
        data() {
            return {
                formItem: {
                    father: null,
                    mother: null,
                    gender: null
                },
                loading: false,
                height: null,
                rules: {
                    father: {type: 'number', required: true, min: 0, max: 300, message: '请输入父亲身高（厘米）', trigger: 'blur', transform: function (value) {
                        return parseFloat(value);
                    }},
                    mother: {type: 'number', required: true, min: 0, max: 300, message: '请输入母亲身高（厘米）', trigger: 'blur', transform: function (value) {
                        return parseFloat(value);
                    }},
                    gender: {required: true, message: '请输入孩子的性别', trigger: 'change'}
                }
            }
        },
        methods: {
            submit() {
                this.$refs['iform'].validate((valid) => {
                    if (!valid) {
                        this.$Message.error('信息输入有误！');
                        return;
                    }
                    this.loading = true;
                    let f = parseFloat(this.formItem.father);
                    let m = parseFloat(this.formItem.mother);
                    if (this.formItem.gender === 'female') {
                        this.height = (f * 0.923 + m) / 2;
                    } else {
                        this.height = (f + m) * 1.08 / 2
                    }
                    this.loading = false;
                });
            }
        }
    }
</script>

<style scoped>
    .parent_predictor .result {
        text-align: center;
        font-size: 22px;
    }
    .countup {
        font-size: 36px;
        font-weight: 900;
    }
    .parent_predictor .tips {
        font-size: 14px;
    }
    .parent_predictor .tips p {
        text-indent: 2em;
        margin-bottom: 10px;
    }
    .parent_predictor .tips .title {
        font-weight: 800;
        padding: 10px 0 5px 0;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-to {
        opacity: 0
    }
</style>