export default {
    data() {
        return {
            greeting: '',
            world: 'World',
            axiosErrorMessages: [],
            isDialogOpen: {
                errorDialog: false,
            },
        }
    },
    computed: {
        hello: function () {
            return this.greeting + ' ' + this.world + '!'
        },
    },
    methods: {
        // サーバー側からのエラーを定義（ブックマーク用）
        setBookmarkAxiosErrorData: function (err) {
            const axiosErrorRes = err.response
            const axiosErrorMessageArray = []

            if (axiosErrorRes) {
                axiosErrorMessageArray.push(
                    'サーバーエラーです。サイトをリロードして再度ブックマークボタンを押してください。'
                )
            }
            this.axiosErrorMessages = axiosErrorMessageArray
            this.isDialogOpen.errorDialog = true
        },
        // サーバー側からのエラーを定義 (入力値のバリデーションエラー用)
        setAxiosErrorData: function (err) {
            const axiosErrorRes = err.response.data
            const axiosErrorMessageArray = []

            if (axiosErrorRes.errors) {
                const axiosvalidationErrorRes = axiosErrorRes.errors

                Object.keys(axiosvalidationErrorRes).map((dataField) => {
                    axiosErrorMessageArray.push(
                        axiosvalidationErrorRes[dataField]
                    )
                })
            } else {
                axiosErrorMessageArray.push(
                    '回答が送信されませんでした。再度送信してください。'
                )
            }
            this.axiosErrorMessages = axiosErrorMessageArray.flat()
            console.log(this.axiosErrorMessages)
            this.isDialogOpen.errorDialog = true
        },
        // ダイアログを閉じる
        closeDialog(dialogName) {
            this.isDialogOpen[dialogName] = false
        },
        logout() {
            axios
                .post('logout')
                .then((res) => {
                    location.href = '/'
                })
                .catch((err) => console.log(err))
        },
    },
}
