<template>
    <div class="container">
        <Row>
            <Col span="24">
                <Form ref="iform" :model="formItem" :label-width="80" :rules="rules">
                    <Form-item label="文件类型" prop="source">
                        <Select :model.sync="formItem.source" placeholder="请选择类型" v-if="sources" name="source">
                            <Option v-for="(s, index) in sources" :value="index" :key="index">{{ s }}</Option>
                        </Select>
                    </Form-item>
                    <Form-item label="基因文件" prop="genotype">
                        <input type="file" :model="formItem.genotype" name="genotype">
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
        <Row v-if="height" class="predict_height">
            <Col span="24">
                预测您的基因身高: <CountUp :start="0" :end="height" :decimals="2" :duration="2.5" class="countup"></CountUp> cm
            </Col>
        </Row>
        <Row v-if="height" class="tips">
            <Col span="20" offset="2">
                <p></p>
            </Col>
        </Row>
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
                    genotype: {required: true, message: '请上传基因型文件', trigger: 'blur'},
                    gender: {required: true, message: '请输入孩子的性别', trigger: 'change'}
                },
                sources: {},
                height: null,
                loading: false
            }
        },
        methods: {
            getSource() {
                axios.get('/api/sources').then(function (res) {
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
                    let fd = new FormData(document.getElementById('gt_form'));
                    axios.post('/api/predict', fd).then(function (res) {
                        if ('data' in res) {
                            if ('height' in res.data) {
                                this.height = Number(res.data.height);
                            } else if ('error' in res.data) {
                                this.$Message.error(res.data.error);
                            } else {
                                this.$Message.error('无法预测，文件格式不对或无法识别！');
                            }
                        } else {
                            this.$Message.error('无法预测，文件格式不对或无法识别！');
                        }
                        this.loading = false;
                    }.bind(this)).catch(function (res) {
                        console.log(res);
                        this.$Message.error('无法预测，文件格式不对或无法识别！');
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
    .predict_height {
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
    .tips {
        font-size: 14px;
    }
    .tips p {
        text-indent: 2em;
        margin-bottom: 10px;
    }
    .tips .title {
        font-weight: 800;
        padding: 10px 0 5px 0;
    }
</style>
