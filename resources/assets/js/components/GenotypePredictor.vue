<template>
    <div class="container">
        <Row>
            <i-col span="24">
                <i-form :model="formItem" :label-width="80" id="gt_form">
                    <Form-item label="文件类型">
                        <i-select :model.sync="formItem.source" placeholder="请选择类型" v-if="sources" name="source">
                            <i-option v-for="(s, index) in sources" :value="index" :key="index">{{ s }}</i-option>
                        </i-select>
                    </Form-item>
                    <Form-item label="基因文件">
                        <input type="file" :model="formItem.genotype" name="genotype">
                    </Form-item>
                    <Form-item label="性别">
                        <i-select :model.sync="formItem.gender" placeholder="请选择性别" name="gender">
                            <i-option value="male">男</i-option>
                            <i-option value="female">女</i-option>
                        </i-select>
                    </Form-item>
                    <Form-item>
                        <i-button type="primary" :loading="loading" @click="submit">提交</i-button>
                    </Form-item>
                </i-form>
            </i-col>
        </Row>
        <Row v-if="height" class="predict_height">
            <i-col span="24">
                预测您的基因身高: <i-count-up :start="0" :end="height" :decimals="2" :duration="2.5" class="countup"></i-count-up> cm
            </i-col>
        </Row>
    </div>
</template>

<script>
    export default {
        name: 'genotype_predictor',
        data() {
            return {
                formItem: {
                    genotype: undefined,
                    gender: undefined,
                    source: undefined
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
                this.loading = true;
                let fd = new FormData(document.getElementById('gt_form'));
                axios.post('/api/predict', fd).then(function(res) {
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
                }.bind(this)).catch(function(res) {
                    console.log(res);
                    this.$Message.error('无法预测，文件格式不对或无法识别！');
                    this.loading = false;
                }.bind(this));
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
    .countup {
        font-size: 36px;
        font-weight: 900;
    }
</style>
