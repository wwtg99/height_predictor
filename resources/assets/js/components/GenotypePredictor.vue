<template>
    <div class="genotype_predictor">
        <Row>
            <Col span="24">
                <Form ref="iform" :model="formItem" :label-width="80" :rules="rules" id="gt_form">
                    <Form-item label="文件类型" prop="source">
                        <Select v-model="formItem.source" placeholder="请选择数据类型，自定义类型请参考示例文件，默认自定义" v-if="sources">
                            <Option v-for="(s, index) in sources" :value="index" :key="index">{{ s }}</Option>
                        </Select>
                    </Form-item>
                    <Form-item label="基因文件" prop="genotype">
                        <input type="file" @change="changeFile" name="genotype">&nbsp;&nbsp;<a href="/height_predictor/examples?id=male.txt">示例文件-男</a>&nbsp;&nbsp;<a href="/height_predictor/examples?id=female.txt">示例文件-女</a>
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
                    预测您的基因身高: <CountUp :start="0" :end="height" :decimals="2" :duration="2.5" class="countup"></CountUp> cm
                </Col>
            </Row>
        </transition>
        <transition name="fade">
            <Row v-if="error" class="result">
                <Col span="24">
                    <Alert type="error">{{ error }}</Alert>
                </Col>
            </Row>
        </transition>
        <transition name="fade">
            <Row v-if="height" class="tips">
                <Col span="20" offset="2">
                <p>遗传因素对身高有很大的影响，但是身高还受其他许多因素的影响，如营养、体育运动、良好的睡眠、生活习惯、种族、内分泌、性成熟早晚、远亲婚配等。此预测参考相关研究，使用了和中国人身高相关的 100 多个 <Poptip trigger="hover" class="pop">
                    <Button type="text">SNP</Button>
                    <div slot="content">
                        rs11082671, rs12612930, rs11021504, rs3816804, rs3751599, rs7678436, rs3791679,<br/>
                        rs9825379, rs10513137, rs2284746, rs3738814, rs7513464, rs12410416, rs1926872,<br/>
                        rs1890995, rs3769528, rs4146922, rs7588654, rs6753739, rs10460436, rs13072744,<br/>
                        rs7636293, rs6763931, rs4243400, rs6823268, rs16895802, rs13131350, rs2227901,<br/>
                        rs3733309, rs16848425, rs2011962, rs2454206, rs6845999, rs7704138, rs7708474, rs806794,<br/>
                        rs1776897, rs1415701, rs13273123, rs7815909, rs2062078, rs10858250, rs606452,<br/>
                        rs11170624, rs1971762, rs2066808, rs2271266, rs699371, rs7158300, rs10519302, rs2401171,<br/>
                        rs3817428, rs2871865, rs2573652, rs757608, rs3785574, rs8098316, rs4369779, rs16950303,<br/>
                        rs2145272, rs6060369, rs2236164, rs11205277, rs1325598, rs4665736, rs11694842, rs867529,<br/>
                        rs611203, rs1541777, rs10037512, rs537930, rs4282339, rs889014, rs7759938, rs6570507,<br/>
                        rs2510897, rs11107116, rs7153027, rs1659127, rs17782313, rs6772112, rs9818941, rs572169,<br/>
                        rs526896, rs3812163, rs12680655, rs10512248, rs779933, rs234886, rs1042725, rs2093210,<br/>
                        rs11648796, rs4821083, rs2166898, rs3823418, rs12413361, rs17152411, rs3781426,<br/>
                        rs6030712, rs1865760, rs11970475, rs2251830, rs4472734, rs3755206, rs10448080,<br/>
                        rs4733789, rs174547, rs1938679, rs3809128, rs7184046, rs258324, rs2270518, rs12459943,<br/>
                        rs600130, rs41464348, rs142036701, rs148833559, rs148934412, rs137852591
                    </div></Poptip> 位点。</p>
                    <p>从理论上讲，父母的身高（遗传因素）决定着子女身高的生长潜力，而潜力能否充分得到发挥，则有赖于良好的外界环境条件。从某种意义上说，外界环境对身高的增长起着重要的作用。作为父母来说，为了孩子的健美，使长高的潜力更好地发挥出来，还必须注意以下几个方面：</p>
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
        name: 'genotype_predictor',
        data() {
            return {
                formItem: {
                    genotype: null,
                    gender: null,
                    source: null
                },
                rules: {
                    gender: {required: true, message: '请输入性别', trigger: 'change'}
                },
                sources: {},
                height: null,
                loading: false,
                error: ''
            }
        },
        methods: {
            changeFile(e) {
                this.formItem.genotype = e.target.files[0];
            },
            getSource() {
                axios.get('/api/height_predictor/sources').then(function (res) {
                    if ('data' in res) {
                        this.sources = res.data;
                    } else {
                        this.$Message.error('载入文件来源错误！');
                    }
                }.bind(this)).catch(function (res) {
                    this.$Message.error('载入文件来源错误！');
                }.bind(this));
            },
            submit() {
                this.$refs['iform'].validate((valid) => {
                    if (!valid) {
                        this.$Message.error('信息输入有误！');
                        return;
                    }
                    this.loading = true;
                    this.error = null;
                    this.height = null;
                    let fd = new FormData();
                    fd.append('source', this.formItem.source);
                    fd.append('genotype', this.formItem.genotype, this.formItem.genotype.name);
                    fd.append('gender', this.formItem.gender);
                    this.$Message.info('预测中，请稍等...');
                    let conf = {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    };
                    axios.post('/api/height_predictor/predict', fd, conf).then(function (res) {
                        if ('data' in res) {
                            if ('height' in res.data) {
                                this.height = Number(res.data.height);
                            } else if ('error' in res.data) {
                                this.$Message.error(res.data.error);
                                this.error = res.data.error;
                            } else {
                                this.$Message.error('无法预测，文件格式不对或无法识别！');
                                this.error = '无法预测，文件格式不对或无法识别！'
                            }
                        } else {
                            this.$Message.error('无法预测，文件格式不对或无法识别！');
                            this.error = '无法预测，文件格式不对或无法识别！';
                        }
                        this.loading = false;
                    }.bind(this)).catch(function (res) {
                        console.log(res);
                        this.$Message.error('无法预测，文件格式不对或无法识别！');
                        this.error = '无法预测，文件格式不对或无法识别！';
                        this.loading = false;
                    }.bind(this));
                });
            }
        },
        created() {
            this.getSource();
        }
    }
</script>

<style scoped>
    .genotype_predictor {
        font-size: 16px;
    }
    .genotype_predictor .result {
        text-align: center;
        font-size: 22px;
    }
    input[type=file] {
        padding: 6px 12px;
        line-height: 1.42857143;
        vertical-align: middle;
        border: 1px solid #ccc;
        border-radius: 4px;
        color: #333;
        background-color: #fff;
    }
    .countup {
        font-size: 36px;
        font-weight: 900;
    }
    .genotype_predictor .tips {
        font-size: 14px;
    }
    .genotype_predictor .tips p {
        text-indent: 2em;
        margin-bottom: 10px;
    }
    .genotype_predictor .tips .title {
        font-weight: 800;
        padding: 10px 0 5px 0;
    }
    .genotype_predictor .tips .pop {
        text-indent: 0;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-to {
        opacity: 0
    }
</style>
