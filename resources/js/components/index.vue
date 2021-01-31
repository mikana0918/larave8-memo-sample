<template>
  <v-app>
    <v-card
      max-width="100%"
      class="mx-auto"
    >
        <v-app-bar
          dark
          fixed
        >
          <v-app-bar-nav-icon></v-app-bar-nav-icon>
          <v-toolbar-title>サンプルアプリ</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn 
                icon 
                v-bind="attrs" 
                v-on="on"
              >
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </template>
            <v-card>
              <v-toolbar
                dark
                color="primary"
              >
                <v-toolbar-title>メモの編集・保存</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                  icon
                  dark
                  @click="dialog = false"
                >
                  <v-icon>mdi-close</v-icon>
                </v-btn>
              </v-toolbar>
              <v-form>
                <v-container>
                  <v-textarea
                    v-model="note.note_contents"
                    counter="140"
                    hint="メモ内容を入力"
                    label="メモ"
                  ></v-textarea>
                  <v-btn
                    elevation="2"
                    @click="save(note)"
                  >保存</v-btn>
                </v-container>
              </v-form>
            </v-card>
          </v-dialog>
        </v-app-bar>

        <v-container style="margin-top: 56px;">
          <v-row dense>
            <v-col
              v-for="(note, i) in notes"
              :key="i"
              cols="12"
            >
              <v-card
                :color="colorizeByItemId(note)"
                dark
              > 
                <v-system-bar
                  window
                  color="primary"
                >
                  <v-spacer></v-spacer>
                  <v-icon @click="destroy(note)">mdi-close</v-icon>
                </v-system-bar>
                    <div class="d-flex flex-no-wrap justify-space-between" @click="openUpdateModal(note)">
                        <div>
                          <v-card-title
                            class="headline"
                            v-text="note.note_contents"
                          ></v-card-title>
                          <v-card-subtitle v-text="note.updated_at"></v-card-subtitle>
                        </div>
                    </div>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
    </v-card>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      notes: [], //noteのデータを格納するarray型の空データを置く
      dialog: false,
      dialogUpdate: false,
      note: {
        id: 0,
        note_contents: ''
      }
    }),
    mounted() {
      // APIデータ読み込み
      this.read()
    },
    methods: {
      // Item.idが偶数の場合とそれ以外(奇数)で、背景色を変えてみる
      colorizeByItemId(note) {
        if(note.id % 2 === 0 ) {
          return '#1858D9'
        } else {
          return '#132A59'
        }
      },
      // [API]読み込み
      read() {
        this.axios.get('/api/note').then((response) => {
          console.log(response.data)
          this.notes = response.data // ここでdataのnotesにノートの一覧データを入れる
        })
      },
      // [API]保存
      save(note) {
        //1. 保存
        this.axios.post('/api/note', note).then((response) => {
          console.log(response.data)
          alert('メモの保存が成功しました')
        })
        // 2. リロード
        location.reload()
        // 3. 編集用データ初期化
        this.note.id = 0
        this.note.note_contents = ''
      },
      // [API]削除
      destroy(note) {
        if(confirm('本当に削除してもいいですか？')) {
          //axiosのDELETEメソッドはデータの渡し方が異なる(実際はPOSTでもOK)
          this.axios.delete('/api/note', {data: {id: note.id}}).then((response) => {
            console.log(response.data)
            alert('メモの削除に成功しました')
          }).then(() => {
            location.reload()
          })
        }
      },
      // モーダルをアップデートで開くときの処理
      openUpdateModal(note) {
        this.note = note
        this.dialog = true
        return
      }
    }
  }
</script>