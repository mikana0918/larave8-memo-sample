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
                <v-toolbar-title>新規作成</v-toolbar-title>
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
                    @click="create(note)"
                  >作成</v-btn>
                </v-container>
              </v-form>
            </v-card>
          </v-dialog>
        </v-app-bar>

        <v-container style="margin-top: 56px;">
          <v-row dense>
            <v-col cols="12">
              <v-card
                color="#385F73"
                dark
              >
                <v-card-title class="headline">
                  サンプルメモアプリ
                </v-card-title>
                <v-card-subtitle>ここではメモの追加と削除ができます</v-card-subtitle>
              </v-card>
            </v-col>

            <v-col
              v-for="(note, i) in notes"
              :key="i"
              cols="12"
            >
              <v-card
                :color="colorizeByItemId(note)"
                dark
              >
                <div class="d-flex flex-no-wrap justify-space-between">
                  <div>
                    <v-card-title
                      class="headline"
                      v-text="note.note_contents"
                    ></v-card-title>
                    <v-card-subtitle v-text="note.updated_at"></v-card-subtitle>
                  </div>
                  <v-card-actions>
                    <v-btn text>
                      編集
                    </v-btn>
                    <v-btn text>
                      削除
                    </v-btn>
                  </v-card-actions>
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
      items: [
        {
          color: '#1F7087',
          src: 'https://cdn.vuetifyjs.com/images/cards/foster.jpg',
          title: 'Supermodel',
          artist: 'Foster the People',
        },
        {
          color: '#952175',
          src: 'https://cdn.vuetifyjs.com/images/cards/halcyon.png',
          title: 'Halcyon Days',
          artist: 'Ellie Goulding',
        },
      ],
      notes: [], //noteのデータを格納するarray型の空データを置く
      dialog: false,
      note: {
        id: 0,
        note_contents: ''
      }
    }),
    mounted() {
      this.read()
    },
    methods: {
      // Item.idが偶数の場合とそれ以外(奇数)で、背景色を変えてみる
      colorizeByItemId(note) {
        if(note.id % 2 === 0 ) {
          return '#1F7087'
        } else {
          return '#952175'
        }
      },
      // [API]読み込み
      read() {
        this.axios.get('/api/note').then((response) => {
          console.log(response.data)
          this.notes = response.data // ここでdataのnotesにノートの一覧データを入れる
        })
      },
      // [API]新規作成
      create(note) {
        //1. 保存
        this.axios.post('/api/note', note).then((response) => {
          console.log(response.data)
          alert('メモの保存が成功しました')
        })
        //2. リロード
        location.reload()
      }
    }
  }
</script>