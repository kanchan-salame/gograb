<template>
  <div class="vue-easymde">
    <textarea
      class="vue-simplemde-textarea"
      :name="name"
      :value="modelValue"
      @input="handleInput($event.target.value)"
    />
  </div>
</template>

<script>
// eslint-disable-next-line import/extensions
import EasyMDE from 'easymde';
// eslint-disable-next-line import/extensions
import marked from 'marked';

export default {
  name: 'vue-easymde',
  props: {
    modelValue: String,
    name: String,
    previewClass: String,
    autoinit: {
      type: Boolean,
      default() {
        return true;
      },
    },
    highlight: {
      type: Boolean,
      default() {
        return false;
      },
    },
    sanitize: {
      type: Boolean,
      default() {
        return false;
      },
    },
    configs: {
      type: Object,
      default() {
        return {};
      },
    },
    previewRender: {
      type: Function,
    },
  },
  data() {
    return {
      isValueUpdateFromInner: false,
    };
  },
  mounted() {
    if (this.autoinit) this.initialize();
  },
  deactivated() {
    const editor = this.easymde;
    if (!editor) return;
    const isFullScreen = editor.codemirror.getOption('fullScreen');
    if (isFullScreen) editor.toggleFullScreen();
  },
  methods: {
    initialize() {
      const configs = Object.assign({
        element: this.$el.firstElementChild,
        initialValue: this.modelValue,
        previewRender: this.previewRender,
        renderingConfig: {},
      }, this.configs);

      // 同步 value 和 initialValue 的值 \ Synchronize the values of value and initialValue
      if (configs.initialValue) {
        this.$emit('update:modelValue', configs.initialValue);
      }

      // 判断是否开启代码高亮 \ Determine whether to enable code highlighting
      if (this.highlight) {
        configs.renderingConfig.codeSyntaxHighlighting = true;
      }

      // 设置是否渲染输入的html \ Set whether to render the input html
      marked.setOptions({ sanitize: this.sanitize });

      // 实例化编辑器 \ Instantiated editor
      this.easymde = new EasyMDE(configs);

      // 添加自定义 previewClass \ Add a custom previewClass
      const className = this.previewClass || '';
      this.addPreviewClass(className);

      // 绑定事件 \ Binding event
      this.bindingEvents();

      this.$nextTick(() => {
        this.$emit('initialized', this.easymde);
      });
    },
    bindingEvents() {
      this.easymde.codemirror.on('change', (instance, changeObj) => {
        if (changeObj.origin === 'setValue') {
          return;
        }
        const val = this.easymde.value();
        this.handleInput(val);
      });

      this.easymde.codemirror.on('blur', () => {
        const val = this.easymde.value();
        this.handleBlur(val);
      });
    },
    addPreviewClass(className) {
      const wrapper = this.easymde.codemirror.getWrapperElement();
      const preview = document.createElement('div');
      wrapper.nextSibling.className += ` ${className}`;
      preview.className = `editor-preview ${className}`;
      wrapper.appendChild(preview);
    },
    handleInput(val) {
      this.isValueUpdateFromInner = true;
      this.$emit('update:modelValue', val);
    },
    handleBlur(val) {
      this.isValueUpdateFromInner = true;
      this.$emit('blur', val);
    },
    clearInput(){
      this.easymde.value('');
    }
  },
  
  destroyed() {
    this.easymde = null;
  },
  watch: {
    modelValue(val,newValues) {
      if (this.isValueUpdateFromInner) {
        this.isValueUpdateFromInner = false;
      } else {
        this.easymde.value(val);
      }
    },
  },
};
</script>

<style>
  .vue-easymde .markdown-body {
    padding: 0.5em
  }

  .vue-easymde .editor-preview-active, .vue-easymde .editor-preview-active-side {
    display: block;
  }
</style>
