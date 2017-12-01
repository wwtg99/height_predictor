<template>
    <div class="container">
        <Row>
            <i-col span="24">
                <i-form :model="formItem" :label-width="80">
                    <Form-item label="父亲身高">
                        <i-input :value.sync="formItem.father" placeholder="请输入"></i-input> cm
                    </Form-item>
                    <Form-item label="母亲身高">
                        <Input-number :value.sync="formItem.mother" placeholder="请输入" :min="0" :max="300"></Input-number> cm
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
        name: 'parent_predictor',
        data() {
            return {
                formItem: {
                    father: 0,
                    mother: 0,
                    gender: undefined
                },
                loading: false,
                height: null
            }
        },
        methods: {
            submit() {
                this.loading = true;
                console.log(this.formItem);
                if (this.formItem.gender === 'female') {
                    this.height = (this.formItem.father * 0.923 + this.formItem.mother) / 2;
                } else {
                    this.height = (this.formItem.father + this.formItem.mother) * 1.08 / 2
                }
                console.log(this.height);
                this.loading = false;
            }
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