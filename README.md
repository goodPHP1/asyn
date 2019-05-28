# asynchronous 简单的异步处理
异步处理数据

## 相关

[具体参考 lazyload README](https://github.com/goodPHP1/asyn)


### 异步优势
- 异步编程，我们从字面上理解，可以理解为代码非同步执行的
- 有复杂的业务逻辑可以分拆为多个事件处理逻辑
- 并发，结合非阻塞的IO，可以在单个进程（或线程）内实现对IO的并发访问
- 效率，在没有事件机制的场景中，我们往往需要使用轮询的方式判断一个事件是否产生

### 总体逻辑
1. 访问接口时先返回信息。
2. 把耗时的任务丢给另外一个程序执行。