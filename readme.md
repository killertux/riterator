## About

Have you ever wanted you could use an iterator in PHP that was very similar to that of Rust. Or maybe you just want a more powerful iterator in PHP. Maybe PHP iterators are giving you chills with all that rewind and key methods... Well, you just found what you were looking for.

<b>RIterator</b> (<i>rust iterator</i>) tries to implement an iterator that very closely resembles that of rust. To start, just add this project to your composer, extends the class <code>RIterator\Iterator</code>, and implement your next function.

First, I tried to add an Option class as we have in Rust. Then, I decided to remove it and use `null` because this is probably more PHP idiomatic. But, I am open to suggestions.
