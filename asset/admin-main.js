/*!
 * jQuery JavaScript Library v1.11.1
 * http://jquery.com/
 *
 * Includes Sizzle.js
 * http://sizzlejs.com/
 *
 * Copyright 2005, 2014 jQuery Foundation, Inc. and other contributors
 * Released under the MIT license
 * http://jquery.org/license
 *
 * Date: 2014-05-01T17:42Z
 */

/*!
 * Sizzle CSS Selector Engine v1.10.19
 * http://sizzlejs.com/
 *
 * Copyright 2013 jQuery Foundation, Inc. and other contributors
 * Released under the MIT license
 * http://jquery.org/license
 *
 * Date: 2014-04-18
 */

/*!
 * mustache.js - Logic-less {{mustache}} templates with JavaScript
 * http://github.com/janl/mustache.js
 */

(function(global, factory) {
    typeof module == "object" && typeof module.exports == "object" ? module.exports = global.document ? factory(global, !0) : function(w) {
        if (!w.document) throw new Error("jQuery requires a window with a document");
        return factory(w);
    } : factory(global);
})(typeof window != "undefined" ? window : this, function(window, noGlobal) {
    var deletedIds = [], slice = deletedIds.slice, concat = deletedIds.concat, push = deletedIds.push, indexOf = deletedIds.indexOf, class2type = {}, toString = class2type.toString, hasOwn = class2type.hasOwnProperty, support = {}, version = "1.11.1", jQuery = function(selector, context) {
        return new jQuery.fn.init(selector, context);
    }, rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, rmsPrefix = /^-ms-/, rdashAlpha = /-([\da-z])/gi, fcamelCase = function(all, letter) {
        return letter.toUpperCase();
    };
    jQuery.fn = jQuery.prototype = {
        jquery: version,
        constructor: jQuery
,
        selector: "",
        length: 0,
        toArray: function() {
            return slice.call(this);
        },
        get: function(num) {
            return num != null ? num < 0 ? this[num + this.length] : this[num] : slice.call(this);
        },
        pushStack: function(elems) {
            var ret = jQuery.merge(this.constructor(), elems);
            return ret.prevObject = this, ret.context = this.context, ret;
        },
        each: function(callback, args) {
            return jQuery.each(this, callback, args);
        },
        map: function(callback) {
            return this.pushStack(jQuery.map(this, function(elem, i) {
                return callback.call(elem, i, elem);
            }));
        },
        slice: function() {
            return this.pushStack(slice.apply(this, arguments));
        },
        first: function() {
            return this.eq(0);
        },
        last: function() {
            return this.eq(-1);
        },
        eq: function(
i) {
            var len = this.length, j = +i + (i < 0 ? len : 0);
            return this.pushStack(j >= 0 && j < len ? [ this[j] ] : []);
        },
        end: function() {
            return this.prevObject || this.constructor(null);
        },
        push: push,
        sort: deletedIds.sort,
        splice: deletedIds.splice
    }, jQuery.extend = jQuery.fn.extend = function() {
        var src, copyIsArray, copy, name, options, clone, target = arguments[0] || {}, i = 1, length = arguments.length, deep = !1;
        typeof target == "boolean" && (deep = target, target = arguments[i] || {}, i++), typeof target != "object" && !jQuery.isFunction(target) && (target = {}), i === length && (target = this, i--);
        for (; i < length; i++) if ((options = arguments[i]) != null) for (name in options) {
            src = target[name], copy = options[name];
            if (target === copy) continue;
            deep && copy && (jQuery.isPlainObject(copy) || (copyIsArray = jQuery.isArray
(copy))) ? (copyIsArray ? (copyIsArray = !1, clone = src && jQuery.isArray(src) ? src : []) : clone = src && jQuery.isPlainObject(src) ? src : {}, target[name] = jQuery.extend(deep, clone, copy)) : copy !== undefined && (target[name] = copy);
        }
        return target;
    }, jQuery.extend({
        expando: "jQuery" + (version + Math.random()).replace(/\D/g, ""),
        isReady: !0,
        error: function(msg) {
            throw new Error(msg);
        },
        noop: function() {},
        isFunction: function(obj) {
            return jQuery.type(obj) === "function";
        },
        isArray: Array.isArray || function(obj) {
            return jQuery.type(obj) === "array";
        },
        isWindow: function(obj) {
            return obj != null && obj == obj.window;
        },
        isNumeric: function(obj) {
            return !jQuery.isArray(obj) && obj - parseFloat(obj) >= 0;
        },
        isEmptyObject: function(obj) {
            var name;
            for (
name in obj) return !1;
            return !0;
        },
        isPlainObject: function(obj) {
            var key;
            if (!obj || jQuery.type(obj) !== "object" || obj.nodeType || jQuery.isWindow(obj)) return !1;
            try {
                if (obj.constructor && !hasOwn.call(obj, "constructor") && !hasOwn.call(obj.constructor.prototype, "isPrototypeOf")) return !1;
            } catch (e) {
                return !1;
            }
            if (support.ownLast) for (key in obj) return hasOwn.call(obj, key);
            for (key in obj) ;
            return key === undefined || hasOwn.call(obj, key);
        },
        type: function(obj) {
            return obj == null ? obj + "" : typeof obj == "object" || typeof obj == "function" ? class2type[toString.call(obj)] || "object" : typeof obj;
        },
        globalEval: function(data) {
            data && jQuery.trim(data) && (window.execScript || function(data) {
                window.eval.call(window, data);
            
})(data);
        },
        camelCase: function(string) {
            return string.replace(rmsPrefix, "ms-").replace(rdashAlpha, fcamelCase);
        },
        nodeName: function(elem, name) {
            return elem.nodeName && elem.nodeName.toLowerCase() === name.toLowerCase();
        },
        each: function(obj, callback, args) {
            var value, i = 0, length = obj.length, isArray = isArraylike(obj);
            if (args) if (isArray) for (; i < length; i++) {
                value = callback.apply(obj[i], args);
                if (value === !1) break;
            } else for (i in obj) {
                value = callback.apply(obj[i], args);
                if (value === !1) break;
            } else if (isArray) for (; i < length; i++) {
                value = callback.call(obj[i], i, obj[i]);
                if (value === !1) break;
            } else for (i in obj) {
                value = callback.call(obj[i], i, obj[i]);
                if (value === !1) break;
            
}
            return obj;
        },
        trim: function(text) {
            return text == null ? "" : (text + "").replace(rtrim, "");
        },
        makeArray: function(arr, results) {
            var ret = results || [];
            return arr != null && (isArraylike(Object(arr)) ? jQuery.merge(ret, typeof arr == "string" ? [ arr ] : arr) : push.call(ret, arr)), ret;
        },
        inArray: function(elem, arr, i) {
            var len;
            if (arr) {
                if (indexOf) return indexOf.call(arr, elem, i);
                len = arr.length, i = i ? i < 0 ? Math.max(0, len + i) : i : 0;
                for (; i < len; i++) if (i in arr && arr[i] === elem) return i;
            }
            return -1;
        },
        merge: function(first, second) {
            var len = +second.length, j = 0, i = first.length;
            while (j < len) first[i++] = second[j++];
            if (len !== len) while (second[j] !== undefined) first[i++] = second[j++];
            
return first.length = i, first;
        },
        grep: function(elems, callback, invert) {
            var callbackInverse, matches = [], i = 0, length = elems.length, callbackExpect = !invert;
            for (; i < length; i++) callbackInverse = !callback(elems[i], i), callbackInverse !== callbackExpect && matches.push(elems[i]);
            return matches;
        },
        map: function(elems, callback, arg) {
            var value, i = 0, length = elems.length, isArray = isArraylike(elems), ret = [];
            if (isArray) for (; i < length; i++) value = callback(elems[i], i, arg), value != null && ret.push(value); else for (i in elems) value = callback(elems[i], i, arg), value != null && ret.push(value);
            return concat.apply([], ret);
        },
        guid: 1,
        proxy: function(fn, context) {
            var args, proxy, tmp;
            return typeof context == "string" && (tmp = fn[context], context = fn, fn = tmp), jQuery.isFunction(fn) ? (args = slice.call
(arguments, 2), proxy = function() {
                return fn.apply(context || this, args.concat(slice.call(arguments)));
            }, proxy.guid = fn.guid = fn.guid || jQuery.guid++, proxy) : undefined;
        },
        now: function() {
            return +(new Date);
        },
        support: support
    }), jQuery.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function(i, name) {
        class2type["[object " + name + "]"] = name.toLowerCase();
    });
    function isArraylike(obj) {
        var length = obj.length, type = jQuery.type(obj);
        return type === "function" || jQuery.isWindow(obj) ? !1 : obj.nodeType === 1 && length ? !0 : type === "array" || length === 0 || typeof length == "number" && length > 0 && length - 1 in obj;
    }
    var Sizzle = function(window) {
        var i, support, Expr, getText, isXML, tokenize, compile, select, outermostContext, sortInput, hasDuplicate, setDocument, document, docElem, documentIsHTML, rbuggyQSA
, rbuggyMatches, matches, contains, expando = "sizzle" + -(new Date), preferredDoc = window.document, dirruns = 0, done = 0, classCache = createCache(), tokenCache = createCache(), compilerCache = createCache(), sortOrder = function(a, b) {
            return a === b && (hasDuplicate = !0), 0;
        }, strundefined = typeof undefined, MAX_NEGATIVE = 1 << 31, hasOwn = {}.hasOwnProperty, arr = [], pop = arr.pop, push_native = arr.push, push = arr.push, slice = arr.slice, indexOf = arr.indexOf || function(elem) {
            var i = 0, len = this.length;
            for (; i < len; i++) if (this[i] === elem) return i;
            return -1;
        }, booleans = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped", whitespace = "[\\x20\\t\\r\\n\\f]", characterEncoding = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+", identifier = characterEncoding.replace("w", "w#"), attributes = "\\[" + whitespace + "*(" + characterEncoding + ")(?:" + 
whitespace + "*([*^$|!~]?=)" + whitespace + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + identifier + "))|)" + whitespace + "*\\]", pseudos = ":(" + characterEncoding + ")(?:\\((" + "('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|" + "((?:\\\\.|[^\\\\()[\\]]|" + attributes + ")*)|" + ".*" + ")\\)|)", rtrim = new RegExp("^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" + whitespace + "+$", "g"), rcomma = new RegExp("^" + whitespace + "*," + whitespace + "*"), rcombinators = new RegExp("^" + whitespace + "*([>+~]|" + whitespace + ")" + whitespace + "*"), rattributeQuotes = new RegExp("=" + whitespace + "*([^\\]'\"]*?)" + whitespace + "*\\]", "g"), rpseudo = new RegExp(pseudos), ridentifier = new RegExp("^" + identifier + "$"), matchExpr = {
            ID: new RegExp("^#(" + characterEncoding + ")"),
            CLASS: new RegExp("^\\.(" + characterEncoding + ")"),
            TAG: new RegExp("^(" + characterEncoding.replace("w", "w*") + ")"),
            ATTR: new RegExp
("^" + attributes),
            PSEUDO: new RegExp("^" + pseudos),
            CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + whitespace + "*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" + whitespace + "*(\\d+)|))" + whitespace + "*\\)|)", "i"),
            bool: new RegExp("^(?:" + booleans + ")$", "i"),
            needsContext: new RegExp("^" + whitespace + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + whitespace + "*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)", "i")
        }, rinputs = /^(?:input|select|textarea|button)$/i, rheader = /^h\d$/i, rnative = /^[^{]+\{\s*\[native \w/, rquickExpr = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, rsibling = /[+~]/, rescape = /'|\\/g, runescape = new RegExp("\\\\([\\da-f]{1,6}" + whitespace + "?|(" + whitespace + ")|.)", "ig"), funescape = function(_, escaped, escapedWhitespace) {
            var high = "0x" + escaped - 65536;
            return high !== high || escapedWhitespace ? escaped : high < 0 ? 
String.fromCharCode(high + 65536) : String.fromCharCode(high >> 10 | 55296, high & 1023 | 56320);
        };
        try {
            push.apply(arr = slice.call(preferredDoc.childNodes), preferredDoc.childNodes), arr[preferredDoc.childNodes.length].nodeType;
        } catch (e) {
            push = {
                apply: arr.length ? function(target, els) {
                    push_native.apply(target, slice.call(els));
                } : function(target, els) {
                    var j = target.length, i = 0;
                    while (target[j++] = els[i++]) ;
                    target.length = j - 1;
                }
            };
        }
        function Sizzle(selector, context, results, seed) {
            var match, elem, m, nodeType, i, groups, old, nid, newContext, newSelector;
            (context ? context.ownerDocument || context : preferredDoc) !== document && setDocument(context), context = context || document, results = results || [];
            if (!selector || typeof 
selector != "string") return results;
            if ((nodeType = context.nodeType) !== 1 && nodeType !== 9) return [];
            if (documentIsHTML && !seed) {
                if (match = rquickExpr.exec(selector)) if (m = match[1]) {
                    if (nodeType === 9) {
                        elem = context.getElementById(m);
                        if (!elem || !elem.parentNode) return results;
                        if (elem.id === m) return results.push(elem), results;
                    } else if (context.ownerDocument && (elem = context.ownerDocument.getElementById(m)) && contains(context, elem) && elem.id === m) return results.push(elem), results;
                } else {
                    if (match[2]) return push.apply(results, context.getElementsByTagName(selector)), results;
                    if ((m = match[3]) && support.getElementsByClassName && context.getElementsByClassName) return push.apply(results, context.getElementsByClassName(m)), results;
                
}
                if (support.qsa && (!rbuggyQSA || !rbuggyQSA.test(selector))) {
                    nid = old = expando, newContext = context, newSelector = nodeType === 9 && selector;
                    if (nodeType === 1 && context.nodeName.toLowerCase() !== "object") {
                        groups = tokenize(selector), (old = context.getAttribute("id")) ? nid = old.replace(rescape, "\\$&") : context.setAttribute("id", nid), nid = "[id='" + nid + "'] ", i = groups.length;
                        while (i--) groups[i] = nid + toSelector(groups[i]);
                        newContext = rsibling.test(selector) && testContext(context.parentNode) || context, newSelector = groups.join(",");
                    }
                    if (newSelector) try {
                        return push.apply(results, newContext.querySelectorAll(newSelector)), results;
                    } catch (qsaError) {} finally {
                        old || context.removeAttribute("id");
                    
}
                }
            }
            return select(selector.replace(rtrim, "$1"), context, results, seed);
        }
        function createCache() {
            var keys = [];
            function cache(key, value) {
                return keys.push(key + " ") > Expr.cacheLength && delete cache[keys.shift()], cache[key + " "] = value;
            }
            return cache;
        }
        function markFunction(fn) {
            return fn[expando] = !0, fn;
        }
        function assert(fn) {
            var div = document.createElement("div");
            try {
                return !!fn(div);
            } catch (e) {
                return !1;
            } finally {
                div.parentNode && div.parentNode.removeChild(div), div = null;
            }
        }
        function addHandle(attrs, handler) {
            var arr = attrs.split("|"), i = attrs.length;
            while (i--) Expr.attrHandle[arr[i]] = handler;
        }
        function siblingCheck(
a, b) {
            var cur = b && a, diff = cur && a.nodeType === 1 && b.nodeType === 1 && (~b.sourceIndex || MAX_NEGATIVE) - (~a.sourceIndex || MAX_NEGATIVE);
            if (diff) return diff;
            if (cur) while (cur = cur.nextSibling) if (cur === b) return -1;
            return a ? 1 : -1;
        }
        function createInputPseudo(type) {
            return function(elem) {
                var name = elem.nodeName.toLowerCase();
                return name === "input" && elem.type === type;
            };
        }
        function createButtonPseudo(type) {
            return function(elem) {
                var name = elem.nodeName.toLowerCase();
                return (name === "input" || name === "button") && elem.type === type;
            };
        }
        function createPositionalPseudo(fn) {
            return markFunction(function(argument) {
                return argument = +argument, markFunction(function(seed, matches) {
                    var j, matchIndexes = 
fn([], seed.length, argument), i = matchIndexes.length;
                    while (i--) seed[j = matchIndexes[i]] && (seed[j] = !(matches[j] = seed[j]));
                });
            });
        }
        function testContext(context) {
            return context && typeof context.getElementsByTagName !== strundefined && context;
        }
        support = Sizzle.support = {}, isXML = Sizzle.isXML = function(elem) {
            var documentElement = elem && (elem.ownerDocument || elem).documentElement;
            return documentElement ? documentElement.nodeName !== "HTML" : !1;
        }, setDocument = Sizzle.setDocument = function(node) {
            var hasCompare, doc = node ? node.ownerDocument || node : preferredDoc, parent = doc.defaultView;
            if (doc === document || doc.nodeType !== 9 || !doc.documentElement) return document;
            document = doc, docElem = doc.documentElement, documentIsHTML = !isXML(doc), parent && parent !== parent.top && (parent.addEventListener ? 
parent.addEventListener("unload", function() {
                setDocument();
            }, !1) : parent.attachEvent && parent.attachEvent("onunload", function() {
                setDocument();
            })), support.attributes = assert(function(div) {
                return div.className = "i", !div.getAttribute("className");
            }), support.getElementsByTagName = assert(function(div) {
                return div.appendChild(doc.createComment("")), !div.getElementsByTagName("*").length;
            }), support.getElementsByClassName = rnative.test(doc.getElementsByClassName) && assert(function(div) {
                return div.innerHTML = "<div class='a'></div><div class='a i'></div>", div.firstChild.className = "i", div.getElementsByClassName("i").length === 2;
            }), support.getById = assert(function(div) {
                return docElem.appendChild(div).id = expando, !doc.getElementsByName || !doc.getElementsByName(expando).length;
            }), support.getById ? 
(Expr.find.ID = function(id, context) {
                if (typeof context.getElementById !== strundefined && documentIsHTML) {
                    var m = context.getElementById(id);
                    return m && m.parentNode ? [ m ] : [];
                }
            }, Expr.filter.ID = function(id) {
                var attrId = id.replace(runescape, funescape);
                return function(elem) {
                    return elem.getAttribute("id") === attrId;
                };
            }) : (delete Expr.find.ID, Expr.filter.ID = function(id) {
                var attrId = id.replace(runescape, funescape);
                return function(elem) {
                    var node = typeof elem.getAttributeNode !== strundefined && elem.getAttributeNode("id");
                    return node && node.value === attrId;
                };
            }), Expr.find.TAG = support.getElementsByTagName ? function(tag, context) {
                if (typeof context.getElementsByTagName !== 
strundefined) return context.getElementsByTagName(tag);
            } : function(tag, context) {
                var elem, tmp = [], i = 0, results = context.getElementsByTagName(tag);
                if (tag === "*") {
                    while (elem = results[i++]) elem.nodeType === 1 && tmp.push(elem);
                    return tmp;
                }
                return results;
            }, Expr.find.CLASS = support.getElementsByClassName && function(className, context) {
                if (typeof context.getElementsByClassName !== strundefined && documentIsHTML) return context.getElementsByClassName(className);
            }, rbuggyMatches = [], rbuggyQSA = [];
            if (support.qsa = rnative.test(doc.querySelectorAll)) assert(function(div) {
                div.innerHTML = "<select msallowclip=''><option selected=''></option></select>", div.querySelectorAll("[msallowclip^='']").length && rbuggyQSA.push("[*^$]=" + whitespace + "*(?:''|\"\")"), div.querySelectorAll("[selected]"
).length || rbuggyQSA.push("\\[" + whitespace + "*(?:value|" + booleans + ")"), div.querySelectorAll(":checked").length || rbuggyQSA.push(":checked");
            }), assert(function(div) {
                var input = doc.createElement("input");
                input.setAttribute("type", "hidden"), div.appendChild(input).setAttribute("name", "D"), div.querySelectorAll("[name=d]").length && rbuggyQSA.push("name" + whitespace + "*[*^$|!~]?="), div.querySelectorAll(":enabled").length || rbuggyQSA.push(":enabled", ":disabled"), div.querySelectorAll("*,:x"), rbuggyQSA.push(",.*:");
            });
            return (support.matchesSelector = rnative.test(matches = docElem.matches || docElem.webkitMatchesSelector || docElem.mozMatchesSelector || docElem.oMatchesSelector || docElem.msMatchesSelector)) && assert(function(div) {
                support.disconnectedMatch = matches.call(div, "div"), matches.call(div, "[s!='']:x"), rbuggyMatches.push("!=", pseudos);
            }), rbuggyQSA = rbuggyQSA
.length && new RegExp(rbuggyQSA.join("|")), rbuggyMatches = rbuggyMatches.length && new RegExp(rbuggyMatches.join("|")), hasCompare = rnative.test(docElem.compareDocumentPosition), contains = hasCompare || rnative.test(docElem.contains) ? function(a, b) {
                var adown = a.nodeType === 9 ? a.documentElement : a, bup = b && b.parentNode;
                return a === bup || !!bup && bup.nodeType === 1 && !!(adown.contains ? adown.contains(bup) : a.compareDocumentPosition && a.compareDocumentPosition(bup) & 16);
            } : function(a, b) {
                if (b) while (b = b.parentNode) if (b === a) return !0;
                return !1;
            }, sortOrder = hasCompare ? function(a, b) {
                if (a === b) return hasDuplicate = !0, 0;
                var compare = !a.compareDocumentPosition - !b.compareDocumentPosition;
                return compare ? compare : (compare = (a.ownerDocument || a) === (b.ownerDocument || b) ? a.compareDocumentPosition(b) : 1, 
compare & 1 || !support.sortDetached && b.compareDocumentPosition(a) === compare ? a === doc || a.ownerDocument === preferredDoc && contains(preferredDoc, a) ? -1 : b === doc || b.ownerDocument === preferredDoc && contains(preferredDoc, b) ? 1 : sortInput ? indexOf.call(sortInput, a) - indexOf.call(sortInput, b) : 0 : compare & 4 ? -1 : 1);
            } : function(a, b) {
                if (a === b) return hasDuplicate = !0, 0;
                var cur, i = 0, aup = a.parentNode, bup = b.parentNode, ap = [ a ], bp = [ b ];
                if (!aup || !bup) return a === doc ? -1 : b === doc ? 1 : aup ? -1 : bup ? 1 : sortInput ? indexOf.call(sortInput, a) - indexOf.call(sortInput, b) : 0;
                if (aup === bup) return siblingCheck(a, b);
                cur = a;
                while (cur = cur.parentNode) ap.unshift(cur);
                cur = b;
                while (cur = cur.parentNode) bp.unshift(cur);
                while (ap[i] === bp[i]) i++;
                return i ? 
siblingCheck(ap[i], bp[i]) : ap[i] === preferredDoc ? -1 : bp[i] === preferredDoc ? 1 : 0;
            }, doc;
        }, Sizzle.matches = function(expr, elements) {
            return Sizzle(expr, null, null, elements);
        }, Sizzle.matchesSelector = function(elem, expr) {
            (elem.ownerDocument || elem) !== document && setDocument(elem), expr = expr.replace(rattributeQuotes, "='$1']");
            if (support.matchesSelector && documentIsHTML && (!rbuggyMatches || !rbuggyMatches.test(expr)) && (!rbuggyQSA || !rbuggyQSA.test(expr))) try {
                var ret = matches.call(elem, expr);
                if (ret || support.disconnectedMatch || elem.document && elem.document.nodeType !== 11) return ret;
            } catch (e) {}
            return Sizzle(expr, document, null, [ elem ]).length > 0;
        }, Sizzle.contains = function(context, elem) {
            return (context.ownerDocument || context) !== document && setDocument(context), contains(context, elem);
        
}, Sizzle.attr = function(elem, name) {
            (elem.ownerDocument || elem) !== document && setDocument(elem);
            var fn = Expr.attrHandle[name.toLowerCase()], val = fn && hasOwn.call(Expr.attrHandle, name.toLowerCase()) ? fn(elem, name, !documentIsHTML) : undefined;
            return val !== undefined ? val : support.attributes || !documentIsHTML ? elem.getAttribute(name) : (val = elem.getAttributeNode(name)) && val.specified ? val.value : null;
        }, Sizzle.error = function(msg) {
            throw new Error("Syntax error, unrecognized expression: " + msg);
        }, Sizzle.uniqueSort = function(results) {
            var elem, duplicates = [], j = 0, i = 0;
            hasDuplicate = !support.detectDuplicates, sortInput = !support.sortStable && results.slice(0), results.sort(sortOrder);
            if (hasDuplicate) {
                while (elem = results[i++]) elem === results[i] && (j = duplicates.push(i));
                while (j--) results.splice(duplicates[
j], 1);
            }
            return sortInput = null, results;
        }, getText = Sizzle.getText = function(elem) {
            var node, ret = "", i = 0, nodeType = elem.nodeType;
            if (!nodeType) while (node = elem[i++]) ret += getText(node); else if (nodeType === 1 || nodeType === 9 || nodeType === 11) {
                if (typeof elem.textContent == "string") return elem.textContent;
                for (elem = elem.firstChild; elem; elem = elem.nextSibling) ret += getText(elem);
            } else if (nodeType === 3 || nodeType === 4) return elem.nodeValue;
            return ret;
        }, Expr = Sizzle.selectors = {
            cacheLength: 50,
            createPseudo: markFunction,
            match: matchExpr,
            attrHandle: {},
            find: {},
            relative: {
                ">": {
                    dir: "parentNode",
                    first: !0
                },
                " ": {
                    dir: "parentNode"
                
},
                "+": {
                    dir: "previousSibling",
                    first: !0
                },
                "~": {
                    dir: "previousSibling"
                }
            },
            preFilter: {
                ATTR: function(match) {
                    return match[1] = match[1].replace(runescape, funescape), match[3] = (match[3] || match[4] || match[5] || "").replace(runescape, funescape), match[2] === "~=" && (match[3] = " " + match[3] + " "), match.slice(0, 4);
                },
                CHILD: function(match) {
                    return match[1] = match[1].toLowerCase(), match[1].slice(0, 3) === "nth" ? (match[3] || Sizzle.error(match[0]), match[4] = +(match[4] ? match[5] + (match[6] || 1) : 2 * (match[3] === "even" || match[3] === "odd")), match[5] = +(match[7] + match[8] || match[3] === "odd")) : match[3] && Sizzle.error(match[0]), match;
                },
                PSEUDO: function(match) {
                    var excess
, unquoted = !match[6] && match[2];
                    return matchExpr.CHILD.test(match[0]) ? null : (match[3] ? match[2] = match[4] || match[5] || "" : unquoted && rpseudo.test(unquoted) && (excess = tokenize(unquoted, !0)) && (excess = unquoted.indexOf(")", unquoted.length - excess) - unquoted.length) && (match[0] = match[0].slice(0, excess), match[2] = unquoted.slice(0, excess)), match.slice(0, 3));
                }
            },
            filter: {
                TAG: function(nodeNameSelector) {
                    var nodeName = nodeNameSelector.replace(runescape, funescape).toLowerCase();
                    return nodeNameSelector === "*" ? function() {
                        return !0;
                    } : function(elem) {
                        return elem.nodeName && elem.nodeName.toLowerCase() === nodeName;
                    };
                },
                CLASS: function(className) {
                    var pattern = classCache[className + " "];
                    
return pattern || (pattern = new RegExp("(^|" + whitespace + ")" + className + "(" + whitespace + "|$)")) && classCache(className, function(elem) {
                        return pattern.test(typeof elem.className == "string" && elem.className || typeof elem.getAttribute !== strundefined && elem.getAttribute("class") || "");
                    });
                },
                ATTR: function(name, operator, check) {
                    return function(elem) {
                        var result = Sizzle.attr(elem, name);
                        return result == null ? operator === "!=" : operator ? (result += "", operator === "=" ? result === check : operator === "!=" ? result !== check : operator === "^=" ? check && result.indexOf(check) === 0 : operator === "*=" ? check && result.indexOf(check) > -1 : operator === "$=" ? check && result.slice(-check.length) === check : operator === "~=" ? (" " + result + " ").indexOf(check) > -1 : operator === "|=" ? result === check || result.slice
(0, check.length + 1) === check + "-" : !1) : !0;
                    };
                },
                CHILD: function(type, what, argument, first, last) {
                    var simple = type.slice(0, 3) !== "nth", forward = type.slice(-4) !== "last", ofType = what === "of-type";
                    return first === 1 && last === 0 ? function(elem) {
                        return !!elem.parentNode;
                    } : function(elem, context, xml) {
                        var cache, outerCache, node, diff, nodeIndex, start, dir = simple !== forward ? "nextSibling" : "previousSibling", parent = elem.parentNode, name = ofType && elem.nodeName.toLowerCase(), useCache = !xml && !ofType;
                        if (parent) {
                            if (simple) {
                                while (dir) {
                                    node = elem;
                                    while (node = node[dir]) if (ofType ? node.nodeName.toLowerCase() === name : node.nodeType === 1
) return !1;
                                    start = dir = type === "only" && !start && "nextSibling";
                                }
                                return !0;
                            }
                            start = [ forward ? parent.firstChild : parent.lastChild ];
                            if (forward && useCache) {
                                outerCache = parent[expando] || (parent[expando] = {}), cache = outerCache[type] || [], nodeIndex = cache[0] === dirruns && cache[1], diff = cache[0] === dirruns && cache[2], node = nodeIndex && parent.childNodes[nodeIndex];
                                while (node = ++nodeIndex && node && node[dir] || (diff = nodeIndex = 0) || start.pop()) if (node.nodeType === 1 && ++diff && node === elem) {
                                    outerCache[type] = [ dirruns, nodeIndex, diff ];
                                    break;
                                }
                            } else if (useCache && 
(cache = (elem[expando] || (elem[expando] = {}))[type]) && cache[0] === dirruns) diff = cache[1]; else while (node = ++nodeIndex && node && node[dir] || (diff = nodeIndex = 0) || start.pop()) if ((ofType ? node.nodeName.toLowerCase() === name : node.nodeType === 1) && ++diff) {
                                useCache && ((node[expando] || (node[expando] = {}))[type] = [ dirruns, diff ]);
                                if (node === elem) break;
                            }
                            return diff -= last, diff === first || diff % first === 0 && diff / first >= 0;
                        }
                    };
                },
                PSEUDO: function(pseudo, argument) {
                    var args, fn = Expr.pseudos[pseudo] || Expr.setFilters[pseudo.toLowerCase()] || Sizzle.error("unsupported pseudo: " + pseudo);
                    return fn[expando] ? fn(argument) : fn.length > 1 ? (args = [ pseudo, pseudo, "", argument ], Expr.setFilters.hasOwnProperty(
pseudo.toLowerCase()) ? markFunction(function(seed, matches) {
                        var idx, matched = fn(seed, argument), i = matched.length;
                        while (i--) idx = indexOf.call(seed, matched[i]), seed[idx] = !(matches[idx] = matched[i]);
                    }) : function(elem) {
                        return fn(elem, 0, args);
                    }) : fn;
                }
            },
            pseudos: {
                not: markFunction(function(selector) {
                    var input = [], results = [], matcher = compile(selector.replace(rtrim, "$1"));
                    return matcher[expando] ? markFunction(function(seed, matches, context, xml) {
                        var elem, unmatched = matcher(seed, null, xml, []), i = seed.length;
                        while (i--) if (elem = unmatched[i]) seed[i] = !(matches[i] = elem);
                    }) : function(elem, context, xml) {
                        return input[0] = elem, matcher(input, null
, xml, results), !results.pop();
                    };
                }),
                has: markFunction(function(selector) {
                    return function(elem) {
                        return Sizzle(selector, elem).length > 0;
                    };
                }),
                contains: markFunction(function(text) {
                    return function(elem) {
                        return (elem.textContent || elem.innerText || getText(elem)).indexOf(text) > -1;
                    };
                }),
                lang: markFunction(function(lang) {
                    return ridentifier.test(lang || "") || Sizzle.error("unsupported lang: " + lang), lang = lang.replace(runescape, funescape).toLowerCase(), function(elem) {
                        var elemLang;
                        do if (elemLang = documentIsHTML ? elem.lang : elem.getAttribute("xml:lang") || elem.getAttribute("lang")) return elemLang = elemLang.toLowerCase(), elemLang === lang || elemLang.
indexOf(lang + "-") === 0; while ((elem = elem.parentNode) && elem.nodeType === 1);
                        return !1;
                    };
                }),
                target: function(elem) {
                    var hash = window.location && window.location.hash;
                    return hash && hash.slice(1) === elem.id;
                },
                root: function(elem) {
                    return elem === docElem;
                },
                focus: function(elem) {
                    return elem === document.activeElement && (!document.hasFocus || document.hasFocus()) && !!(elem.type || elem.href || ~elem.tabIndex);
                },
                enabled: function(elem) {
                    return elem.disabled === !1;
                },
                disabled: function(elem) {
                    return elem.disabled === !0;
                },
                checked: function(elem) {
                    var nodeName = elem.nodeName.toLowerCase();
                    
return nodeName === "input" && !!elem.checked || nodeName === "option" && !!elem.selected;
                },
                selected: function(elem) {
                    return elem.parentNode && elem.parentNode.selectedIndex, elem.selected === !0;
                },
                empty: function(elem) {
                    for (elem = elem.firstChild; elem; elem = elem.nextSibling) if (elem.nodeType < 6) return !1;
                    return !0;
                },
                parent: function(elem) {
                    return !Expr.pseudos.empty(elem);
                },
                header: function(elem) {
                    return rheader.test(elem.nodeName);
                },
                input: function(elem) {
                    return rinputs.test(elem.nodeName);
                },
                button: function(elem) {
                    var name = elem.nodeName.toLowerCase();
                    return name === "input" && elem.type === "button" || name === "button"
;
                },
                text: function(elem) {
                    var attr;
                    return elem.nodeName.toLowerCase() === "input" && elem.type === "text" && ((attr = elem.getAttribute("type")) == null || attr.toLowerCase() === "text");
                },
                first: createPositionalPseudo(function() {
                    return [ 0 ];
                }),
                last: createPositionalPseudo(function(matchIndexes, length) {
                    return [ length - 1 ];
                }),
                eq: createPositionalPseudo(function(matchIndexes, length, argument) {
                    return [ argument < 0 ? argument + length : argument ];
                }),
                even: createPositionalPseudo(function(matchIndexes, length) {
                    var i = 0;
                    for (; i < length; i += 2) matchIndexes.push(i);
                    return matchIndexes;
                }),
                odd: createPositionalPseudo(
function(matchIndexes, length) {
                    var i = 1;
                    for (; i < length; i += 2) matchIndexes.push(i);
                    return matchIndexes;
                }),
                lt: createPositionalPseudo(function(matchIndexes, length, argument) {
                    var i = argument < 0 ? argument + length : argument;
                    for (; --i >= 0; ) matchIndexes.push(i);
                    return matchIndexes;
                }),
                gt: createPositionalPseudo(function(matchIndexes, length, argument) {
                    var i = argument < 0 ? argument + length : argument;
                    for (; ++i < length; ) matchIndexes.push(i);
                    return matchIndexes;
                })
            }
        }, Expr.pseudos.nth = Expr.pseudos.eq;
        for (i in {
            radio: !0,
            checkbox: !0,
            file: !0,
            password: !0,
            image: !0
        }) Expr.pseudos[i] = createInputPseudo
(i);
        for (i in {
            submit: !0,
            reset: !0
        }) Expr.pseudos[i] = createButtonPseudo(i);
        function setFilters() {}
        setFilters.prototype = Expr.filters = Expr.pseudos, Expr.setFilters = new setFilters, tokenize = Sizzle.tokenize = function(selector, parseOnly) {
            var matched, match, tokens, type, soFar, groups, preFilters, cached = tokenCache[selector + " "];
            if (cached) return parseOnly ? 0 : cached.slice(0);
            soFar = selector, groups = [], preFilters = Expr.preFilter;
            while (soFar) {
                if (!matched || (match = rcomma.exec(soFar))) match && (soFar = soFar.slice(match[0].length) || soFar), groups.push(tokens = []);
                matched = !1;
                if (match = rcombinators.exec(soFar)) matched = match.shift(), tokens.push({
                    value: matched,
                    type: match[0].replace(rtrim, " ")
                }), soFar = soFar.slice(matched.length);
                
for (type in Expr.filter) (match = matchExpr[type].exec(soFar)) && (!preFilters[type] || (match = preFilters[type](match))) && (matched = match.shift(), tokens.push({
                    value: matched,
                    type: type,
                    matches: match
                }), soFar = soFar.slice(matched.length));
                if (!matched) break;
            }
            return parseOnly ? soFar.length : soFar ? Sizzle.error(selector) : tokenCache(selector, groups).slice(0);
        };
        function toSelector(tokens) {
            var i = 0, len = tokens.length, selector = "";
            for (; i < len; i++) selector += tokens[i].value;
            return selector;
        }
        function addCombinator(matcher, combinator, base) {
            var dir = combinator.dir, checkNonElements = base && dir === "parentNode", doneName = done++;
            return combinator.first ? function(elem, context, xml) {
                while (elem = elem[dir]) if (elem.nodeType === 1 || 
checkNonElements) return matcher(elem, context, xml);
            } : function(elem, context, xml) {
                var oldCache, outerCache, newCache = [ dirruns, doneName ];
                if (xml) {
                    while (elem = elem[dir]) if (elem.nodeType === 1 || checkNonElements) if (matcher(elem, context, xml)) return !0;
                } else while (elem = elem[dir]) if (elem.nodeType === 1 || checkNonElements) {
                    outerCache = elem[expando] || (elem[expando] = {});
                    if ((oldCache = outerCache[dir]) && oldCache[0] === dirruns && oldCache[1] === doneName) return newCache[2] = oldCache[2];
                    outerCache[dir] = newCache;
                    if (newCache[2] = matcher(elem, context, xml)) return !0;
                }
            };
        }
        function elementMatcher(matchers) {
            return matchers.length > 1 ? function(elem, context, xml) {
                var i = matchers.length;
                while (i--) 
if (!matchers[i](elem, context, xml)) return !1;
                return !0;
            } : matchers[0];
        }
        function multipleContexts(selector, contexts, results) {
            var i = 0, len = contexts.length;
            for (; i < len; i++) Sizzle(selector, contexts[i], results);
            return results;
        }
        function condense(unmatched, map, filter, context, xml) {
            var elem, newUnmatched = [], i = 0, len = unmatched.length, mapped = map != null;
            for (; i < len; i++) if (elem = unmatched[i]) if (!filter || filter(elem, context, xml)) newUnmatched.push(elem), mapped && map.push(i);
            return newUnmatched;
        }
        function setMatcher(preFilter, selector, matcher, postFilter, postFinder, postSelector) {
            return postFilter && !postFilter[expando] && (postFilter = setMatcher(postFilter)), postFinder && !postFinder[expando] && (postFinder = setMatcher(postFinder, postSelector)), markFunction(function(seed, 
results, context, xml) {
                var temp, i, elem, preMap = [], postMap = [], preexisting = results.length, elems = seed || multipleContexts(selector || "*", context.nodeType ? [ context ] : context, []), matcherIn = preFilter && (seed || !selector) ? condense(elems, preMap, preFilter, context, xml) : elems, matcherOut = matcher ? postFinder || (seed ? preFilter : preexisting || postFilter) ? [] : results : matcherIn;
                matcher && matcher(matcherIn, matcherOut, context, xml);
                if (postFilter) {
                    temp = condense(matcherOut, postMap), postFilter(temp, [], context, xml), i = temp.length;
                    while (i--) if (elem = temp[i]) matcherOut[postMap[i]] = !(matcherIn[postMap[i]] = elem);
                }
                if (seed) {
                    if (postFinder || preFilter) {
                        if (postFinder) {
                            temp = [], i = matcherOut.length;
                            while (i--) (
elem = matcherOut[i]) && temp.push(matcherIn[i] = elem);
                            postFinder(null, matcherOut = [], temp, xml);
                        }
                        i = matcherOut.length;
                        while (i--) (elem = matcherOut[i]) && (temp = postFinder ? indexOf.call(seed, elem) : preMap[i]) > -1 && (seed[temp] = !(results[temp] = elem));
                    }
                } else matcherOut = condense(matcherOut === results ? matcherOut.splice(preexisting, matcherOut.length) : matcherOut), postFinder ? postFinder(null, results, matcherOut, xml) : push.apply(results, matcherOut);
            });
        }
        function matcherFromTokens(tokens) {
            var checkContext, matcher, j, len = tokens.length, leadingRelative = Expr.relative[tokens[0].type], implicitRelative = leadingRelative || Expr.relative[" "], i = leadingRelative ? 1 : 0, matchContext = addCombinator(function(elem) {
                return elem === checkContext;
            }, implicitRelative
, !0), matchAnyContext = addCombinator(function(elem) {
                return indexOf.call(checkContext, elem) > -1;
            }, implicitRelative, !0), matchers = [ function(elem, context, xml) {
                return !leadingRelative && (xml || context !== outermostContext) || ((checkContext = context).nodeType ? matchContext(elem, context, xml) : matchAnyContext(elem, context, xml));
            } ];
            for (; i < len; i++) if (matcher = Expr.relative[tokens[i].type]) matchers = [ addCombinator(elementMatcher(matchers), matcher) ]; else {
                matcher = Expr.filter[tokens[i].type].apply(null, tokens[i].matches);
                if (matcher[expando]) {
                    j = ++i;
                    for (; j < len; j++) if (Expr.relative[tokens[j].type]) break;
                    return setMatcher(i > 1 && elementMatcher(matchers), i > 1 && toSelector(tokens.slice(0, i - 1).concat({
                        value: tokens[i - 2].type === " " ? "*" : ""
                    
})).replace(rtrim, "$1"), matcher, i < j && matcherFromTokens(tokens.slice(i, j)), j < len && matcherFromTokens(tokens = tokens.slice(j)), j < len && toSelector(tokens));
                }
                matchers.push(matcher);
            }
            return elementMatcher(matchers);
        }
        function matcherFromGroupMatchers(elementMatchers, setMatchers) {
            var bySet = setMatchers.length > 0, byElement = elementMatchers.length > 0, superMatcher = function(seed, context, xml, results, outermost) {
                var elem, j, matcher, matchedCount = 0, i = "0", unmatched = seed && [], setMatched = [], contextBackup = outermostContext, elems = seed || byElement && Expr.find.TAG("*", outermost), dirrunsUnique = dirruns += contextBackup == null ? 1 : Math.random() || .1, len = elems.length;
                outermost && (outermostContext = context !== document && context);
                for (; i !== len && (elem = elems[i]) != null; i++) {
                    if (byElement && 
elem) {
                        j = 0;
                        while (matcher = elementMatchers[j++]) if (matcher(elem, context, xml)) {
                            results.push(elem);
                            break;
                        }
                        outermost && (dirruns = dirrunsUnique);
                    }
                    bySet && ((elem = !matcher && elem) && matchedCount--, seed && unmatched.push(elem));
                }
                matchedCount += i;
                if (bySet && i !== matchedCount) {
                    j = 0;
                    while (matcher = setMatchers[j++]) matcher(unmatched, setMatched, context, xml);
                    if (seed) {
                        if (matchedCount > 0) while (i--) !unmatched[i] && !setMatched[i] && (setMatched[i] = pop.call(results));
                        setMatched = condense(setMatched);
                    }
                    push.apply(results, setMatched), outermost && !seed && setMatched.length > 0 && 
matchedCount + setMatchers.length > 1 && Sizzle.uniqueSort(results);
                }
                return outermost && (dirruns = dirrunsUnique, outermostContext = contextBackup), unmatched;
            };
            return bySet ? markFunction(superMatcher) : superMatcher;
        }
        return compile = Sizzle.compile = function(selector, match) {
            var i, setMatchers = [], elementMatchers = [], cached = compilerCache[selector + " "];
            if (!cached) {
                match || (match = tokenize(selector)), i = match.length;
                while (i--) cached = matcherFromTokens(match[i]), cached[expando] ? setMatchers.push(cached) : elementMatchers.push(cached);
                cached = compilerCache(selector, matcherFromGroupMatchers(elementMatchers, setMatchers)), cached.selector = selector;
            }
            return cached;
        }, select = Sizzle.select = function(selector, context, results, seed) {
            var i, tokens, token, type, find, 
compiled = typeof selector == "function" && selector, match = !seed && tokenize(selector = compiled.selector || selector);
            results = results || [];
            if (match.length === 1) {
                tokens = match[0] = match[0].slice(0);
                if (tokens.length > 2 && (token = tokens[0]).type === "ID" && support.getById && context.nodeType === 9 && documentIsHTML && Expr.relative[tokens[1].type]) {
                    context = (Expr.find.ID(token.matches[0].replace(runescape, funescape), context) || [])[0];
                    if (!context) return results;
                    compiled && (context = context.parentNode), selector = selector.slice(tokens.shift().value.length);
                }
                i = matchExpr.needsContext.test(selector) ? 0 : tokens.length;
                while (i--) {
                    token = tokens[i];
                    if (Expr.relative[type = token.type]) break;
                    if (find = Expr.find[type]) if (seed = find
(token.matches[0].replace(runescape, funescape), rsibling.test(tokens[0].type) && testContext(context.parentNode) || context)) {
                        tokens.splice(i, 1), selector = seed.length && toSelector(tokens);
                        if (!selector) return push.apply(results, seed), results;
                        break;
                    }
                }
            }
            return (compiled || compile(selector, match))(seed, context, !documentIsHTML, results, rsibling.test(selector) && testContext(context.parentNode) || context), results;
        }, support.sortStable = expando.split("").sort(sortOrder).join("") === expando, support.detectDuplicates = !!hasDuplicate, setDocument(), support.sortDetached = assert(function(div1) {
            return div1.compareDocumentPosition(document.createElement("div")) & 1;
        }), assert(function(div) {
            return div.innerHTML = "<a href='#'></a>", div.firstChild.getAttribute("href") === "#";
        }) || addHandle
("type|href|height|width", function(elem, name, isXML) {
            if (!isXML) return elem.getAttribute(name, name.toLowerCase() === "type" ? 1 : 2);
        }), (!support.attributes || !assert(function(div) {
            return div.innerHTML = "<input/>", div.firstChild.setAttribute("value", ""), div.firstChild.getAttribute("value") === "";
        })) && addHandle("value", function(elem, name, isXML) {
            if (!isXML && elem.nodeName.toLowerCase() === "input") return elem.defaultValue;
        }), assert(function(div) {
            return div.getAttribute("disabled") == null;
        }) || addHandle(booleans, function(elem, name, isXML) {
            var val;
            if (!isXML) return elem[name] === !0 ? name.toLowerCase() : (val = elem.getAttributeNode(name)) && val.specified ? val.value : null;
        }), Sizzle;
    }(window);
    jQuery.find = Sizzle, jQuery.expr = Sizzle.selectors, jQuery.expr[":"] = jQuery.expr.pseudos, jQuery.unique = Sizzle.uniqueSort, jQuery.text = 
Sizzle.getText, jQuery.isXMLDoc = Sizzle.isXML, jQuery.contains = Sizzle.contains;
    var rneedsContext = jQuery.expr.match.needsContext, rsingleTag = /^<(\w+)\s*\/?>(?:<\/\1>|)$/, risSimple = /^.[^:#\[\.,]*$/;
    function winnow(elements, qualifier, not) {
        if (jQuery.isFunction(qualifier)) return jQuery.grep(elements, function(elem, i) {
            return !!qualifier.call(elem, i, elem) !== not;
        });
        if (qualifier.nodeType) return jQuery.grep(elements, function(elem) {
            return elem === qualifier !== not;
        });
        if (typeof qualifier == "string") {
            if (risSimple.test(qualifier)) return jQuery.filter(qualifier, elements, not);
            qualifier = jQuery.filter(qualifier, elements);
        }
        return jQuery.grep(elements, function(elem) {
            return jQuery.inArray(elem, qualifier) >= 0 !== not;
        });
    }
    jQuery.filter = function(expr, elems, not) {
        var elem = elems[0];
        return not && 
(expr = ":not(" + expr + ")"), elems.length === 1 && elem.nodeType === 1 ? jQuery.find.matchesSelector(elem, expr) ? [ elem ] : [] : jQuery.find.matches(expr, jQuery.grep(elems, function(elem) {
            return elem.nodeType === 1;
        }));
    }, jQuery.fn.extend({
        find: function(selector) {
            var i, ret = [], self = this, len = self.length;
            if (typeof selector != "string") return this.pushStack(jQuery(selector).filter(function() {
                for (i = 0; i < len; i++) if (jQuery.contains(self[i], this)) return !0;
            }));
            for (i = 0; i < len; i++) jQuery.find(selector, self[i], ret);
            return ret = this.pushStack(len > 1 ? jQuery.unique(ret) : ret), ret.selector = this.selector ? this.selector + " " + selector : selector, ret;
        },
        filter: function(selector) {
            return this.pushStack(winnow(this, selector || [], !1));
        },
        not: function(selector) {
            return this.pushStack
(winnow(this, selector || [], !0));
        },
        is: function(selector) {
            return !!winnow(this, typeof selector == "string" && rneedsContext.test(selector) ? jQuery(selector) : selector || [], !1).length;
        }
    });
    var rootjQuery, document = window.document, rquickExpr = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/, init = jQuery.fn.init = function(selector, context) {
        var match, elem;
        if (!selector) return this;
        if (typeof selector == "string") {
            selector.charAt(0) === "<" && selector.charAt(selector.length - 1) === ">" && selector.length >= 3 ? match = [ null, selector, null ] : match = rquickExpr.exec(selector);
            if (match && (match[1] || !context)) {
                if (match[1]) {
                    context = context instanceof jQuery ? context[0] : context, jQuery.merge(this, jQuery.parseHTML(match[1], context && context.nodeType ? context.ownerDocument || context : document, !0));
                    if (rsingleTag
.test(match[1]) && jQuery.isPlainObject(context)) for (match in context) jQuery.isFunction(this[match]) ? this[match](context[match]) : this.attr(match, context[match]);
                    return this;
                }
                elem = document.getElementById(match[2]);
                if (elem && elem.parentNode) {
                    if (elem.id !== match[2]) return rootjQuery.find(selector);
                    this.length = 1, this[0] = elem;
                }
                return this.context = document, this.selector = selector, this;
            }
            return !context || context.jquery ? (context || rootjQuery).find(selector) : this.constructor(context).find(selector);
        }
        return selector.nodeType ? (this.context = this[0] = selector, this.length = 1, this) : jQuery.isFunction(selector) ? typeof rootjQuery.ready != "undefined" ? rootjQuery.ready(selector) : selector(jQuery) : (selector.selector !== undefined && (this.selector = selector.selector, this
.context = selector.context), jQuery.makeArray(selector, this));
    };
    init.prototype = jQuery.fn, rootjQuery = jQuery(document);
    var rparentsprev = /^(?:parents|prev(?:Until|All))/, guaranteedUnique = {
        children: !0,
        contents: !0,
        next: !0,
        prev: !0
    };
    jQuery.extend({
        dir: function(elem, dir, until) {
            var matched = [], cur = elem[dir];
            while (cur && cur.nodeType !== 9 && (until === undefined || cur.nodeType !== 1 || !jQuery(cur).is(until))) cur.nodeType === 1 && matched.push(cur), cur = cur[dir];
            return matched;
        },
        sibling: function(n, elem) {
            var r = [];
            for (; n; n = n.nextSibling) n.nodeType === 1 && n !== elem && r.push(n);
            return r;
        }
    }), jQuery.fn.extend({
        has: function(target) {
            var i, targets = jQuery(target, this), len = targets.length;
            return this.filter(function() {
                for (i = 0
; i < len; i++) if (jQuery.contains(this, targets[i])) return !0;
            });
        },
        closest: function(selectors, context) {
            var cur, i = 0, l = this.length, matched = [], pos = rneedsContext.test(selectors) || typeof selectors != "string" ? jQuery(selectors, context || this.context) : 0;
            for (; i < l; i++) for (cur = this[i]; cur && cur !== context; cur = cur.parentNode) if (cur.nodeType < 11 && (pos ? pos.index(cur) > -1 : cur.nodeType === 1 && jQuery.find.matchesSelector(cur, selectors))) {
                matched.push(cur);
                break;
            }
            return this.pushStack(matched.length > 1 ? jQuery.unique(matched) : matched);
        },
        index: function(elem) {
            return elem ? typeof elem == "string" ? jQuery.inArray(this[0], jQuery(elem)) : jQuery.inArray(elem.jquery ? elem[0] : elem, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1;
        },
        add: function(selector, context
) {
            return this.pushStack(jQuery.unique(jQuery.merge(this.get(), jQuery(selector, context))));
        },
        addBack: function(selector) {
            return this.add(selector == null ? this.prevObject : this.prevObject.filter(selector));
        }
    });
    function sibling(cur, dir) {
        do cur = cur[dir]; while (cur && cur.nodeType !== 1);
        return cur;
    }
    jQuery.each({
        parent: function(elem) {
            var parent = elem.parentNode;
            return parent && parent.nodeType !== 11 ? parent : null;
        },
        parents: function(elem) {
            return jQuery.dir(elem, "parentNode");
        },
        parentsUntil: function(elem, i, until) {
            return jQuery.dir(elem, "parentNode", until);
        },
        next: function(elem) {
            return sibling(elem, "nextSibling");
        },
        prev: function(elem) {
            return sibling(elem, "previousSibling");
        },
        nextAll: function(elem) {
            
return jQuery.dir(elem, "nextSibling");
        },
        prevAll: function(elem) {
            return jQuery.dir(elem, "previousSibling");
        },
        nextUntil: function(elem, i, until) {
            return jQuery.dir(elem, "nextSibling", until);
        },
        prevUntil: function(elem, i, until) {
            return jQuery.dir(elem, "previousSibling", until);
        },
        siblings: function(elem) {
            return jQuery.sibling((elem.parentNode || {}).firstChild, elem);
        },
        children: function(elem) {
            return jQuery.sibling(elem.firstChild);
        },
        contents: function(elem) {
            return jQuery.nodeName(elem, "iframe") ? elem.contentDocument || elem.contentWindow.document : jQuery.merge([], elem.childNodes);
        }
    }, function(name, fn) {
        jQuery.fn[name] = function(until, selector) {
            var ret = jQuery.map(this, fn, until);
            return name.slice(-5) !== "Until" && (selector = until), selector && typeof 
selector == "string" && (ret = jQuery.filter(selector, ret)), this.length > 1 && (guaranteedUnique[name] || (ret = jQuery.unique(ret)), rparentsprev.test(name) && (ret = ret.reverse())), this.pushStack(ret);
        };
    });
    var rnotwhite = /\S+/g, optionsCache = {};
    function createOptions(options) {
        var object = optionsCache[options] = {};
        return jQuery.each(options.match(rnotwhite) || [], function(_, flag) {
            object[flag] = !0;
        }), object;
    }
    jQuery.Callbacks = function(options) {
        options = typeof options == "string" ? optionsCache[options] || createOptions(options) : jQuery.extend({}, options);
        var firing, memory, fired, firingLength, firingIndex, firingStart, list = [], stack = !options.once && [], fire = function(data) {
            memory = options.memory && data, fired = !0, firingIndex = firingStart || 0, firingStart = 0, firingLength = list.length, firing = !0;
            for (; list && firingIndex < firingLength
; firingIndex++) if (list[firingIndex].apply(data[0], data[1]) === !1 && options.stopOnFalse) {
                memory = !1;
                break;
            }
            firing = !1, list && (stack ? stack.length && fire(stack.shift()) : memory ? list = [] : self.disable());
        }, self = {
            add: function() {
                if (list) {
                    var start = list.length;
                    (function add(args) {
                        jQuery.each(args, function(_, arg) {
                            var type = jQuery.type(arg);
                            type === "function" ? (!options.unique || !self.has(arg)) && list.push(arg) : arg && arg.length && type !== "string" && add(arg);
                        });
                    })(arguments), firing ? firingLength = list.length : memory && (firingStart = start, fire(memory));
                }
                return this;
            },
            remove: function() {
                return list && jQuery
.each(arguments, function(_, arg) {
                    var index;
                    while ((index = jQuery.inArray(arg, list, index)) > -1) list.splice(index, 1), firing && (index <= firingLength && firingLength--, index <= firingIndex && firingIndex--);
                }), this;
            },
            has: function(fn) {
                return fn ? jQuery.inArray(fn, list) > -1 : !!list && !!list.length;
            },
            empty: function() {
                return list = [], firingLength = 0, this;
            },
            disable: function() {
                return list = stack = memory = undefined, this;
            },
            disabled: function() {
                return !list;
            },
            lock: function() {
                return stack = undefined, memory || self.disable(), this;
            },
            locked: function() {
                return !stack;
            },
            fireWith: function(context, args) {
                return list && 
(!fired || stack) && (args = args || [], args = [ context, args.slice ? args.slice() : args ], firing ? stack.push(args) : fire(args)), this;
            },
            fire: function() {
                return self.fireWith(this, arguments), this;
            },
            fired: function() {
                return !!fired;
            }
        };
        return self;
    }, jQuery.extend({
        Deferred: function(func) {
            var tuples = [ [ "resolve", "done", jQuery.Callbacks("once memory"), "resolved" ], [ "reject", "fail", jQuery.Callbacks("once memory"), "rejected" ], [ "notify", "progress", jQuery.Callbacks("memory") ] ], state = "pending", promise = {
                state: function() {
                    return state;
                },
                always: function() {
                    return deferred.done(arguments).fail(arguments), this;
                },
                then: function() {
                    var fns = arguments;
                    return jQuery
.Deferred(function(newDefer) {
                        jQuery.each(tuples, function(i, tuple) {
                            var fn = jQuery.isFunction(fns[i]) && fns[i];
                            deferred[tuple[1]](function() {
                                var returned = fn && fn.apply(this, arguments);
                                returned && jQuery.isFunction(returned.promise) ? returned.promise().done(newDefer.resolve).fail(newDefer.reject).progress(newDefer.notify) : newDefer[tuple[0] + "With"](this === promise ? newDefer.promise() : this, fn ? [ returned ] : arguments);
                            });
                        }), fns = null;
                    }).promise();
                },
                promise: function(obj) {
                    return obj != null ? jQuery.extend(obj, promise) : promise;
                }
            }, deferred = {};
            return promise.pipe = promise.then, jQuery.each(tuples, function(i, tuple) {
                var list = tuple
[2], stateString = tuple[3];
                promise[tuple[1]] = list.add, stateString && list.add(function() {
                    state = stateString;
                }, tuples[i ^ 1][2].disable, tuples[2][2].lock), deferred[tuple[0]] = function() {
                    return deferred[tuple[0] + "With"](this === deferred ? promise : this, arguments), this;
                }, deferred[tuple[0] + "With"] = list.fireWith;
            }), promise.promise(deferred), func && func.call(deferred, deferred), deferred;
        },
        when: function(subordinate) {
            var i = 0, resolveValues = slice.call(arguments), length = resolveValues.length, remaining = length !== 1 || subordinate && jQuery.isFunction(subordinate.promise) ? length : 0, deferred = remaining === 1 ? subordinate : jQuery.Deferred(), updateFunc = function(i, contexts, values) {
                return function(value) {
                    contexts[i] = this, values[i] = arguments.length > 1 ? slice.call(arguments) : 
value, values === progressValues ? deferred.notifyWith(contexts, values) : --remaining || deferred.resolveWith(contexts, values);
                };
            }, progressValues, progressContexts, resolveContexts;
            if (length > 1) {
                progressValues = new Array(length), progressContexts = new Array(length), resolveContexts = new Array(length);
                for (; i < length; i++) resolveValues[i] && jQuery.isFunction(resolveValues[i].promise) ? resolveValues[i].promise().done(updateFunc(i, resolveContexts, resolveValues)).fail(deferred.reject).progress(updateFunc(i, progressContexts, progressValues)) : --remaining;
            }
            return remaining || deferred.resolveWith(resolveContexts, resolveValues), deferred.promise();
        }
    });
    var readyList;
    jQuery.fn.ready = function(fn) {
        return jQuery.ready.promise().done(fn), this;
    }, jQuery.extend({
        isReady: !1,
        readyWait: 1,
        holdReady: function(hold) {
            
hold ? jQuery.readyWait++ : jQuery.ready(!0);
        },
        ready: function(wait) {
            if (wait === !0 ? --jQuery.readyWait : jQuery.isReady) return;
            if (!document.body) return setTimeout(jQuery.ready);
            jQuery.isReady = !0;
            if (wait !== !0 && --jQuery.readyWait > 0) return;
            readyList.resolveWith(document, [ jQuery ]), jQuery.fn.triggerHandler && (jQuery(document).triggerHandler("ready"), jQuery(document).off("ready"));
        }
    });
    function detach() {
        document.addEventListener ? (document.removeEventListener("DOMContentLoaded", completed, !1), window.removeEventListener("load", completed, !1)) : (document.detachEvent("onreadystatechange", completed), window.detachEvent("onload", completed));
    }
    function completed() {
        if (document.addEventListener || event.type === "load" || document.readyState === "complete") detach(), jQuery.ready();
    }
    jQuery.ready.promise = function(obj) {
        if (!
readyList) {
            readyList = jQuery.Deferred();
            if (document.readyState === "complete") setTimeout(jQuery.ready); else if (document.addEventListener) document.addEventListener("DOMContentLoaded", completed, !1), window.addEventListener("load", completed, !1); else {
                document.attachEvent("onreadystatechange", completed), window.attachEvent("onload", completed);
                var top = !1;
                try {
                    top = window.frameElement == null && document.documentElement;
                } catch (e) {}
                top && top.doScroll && function doScrollCheck() {
                    if (!jQuery.isReady) {
                        try {
                            top.doScroll("left");
                        } catch (e) {
                            return setTimeout(doScrollCheck, 50);
                        }
                        detach(), jQuery.ready();
                    }
                }();
            }
        }
        
return readyList.promise(obj);
    };
    var strundefined = typeof undefined, i;
    for (i in jQuery(support)) break;
    support.ownLast = i !== "0", support.inlineBlockNeedsLayout = !1, jQuery(function() {
        var val, div, body, container;
        body = document.getElementsByTagName("body")[0];
        if (!body || !body.style) return;
        div = document.createElement("div"), container = document.createElement("div"), container.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", body.appendChild(container).appendChild(div), typeof div.style.zoom !== strundefined && (div.style.cssText = "display:inline;margin:0;border:0;padding:1px;width:1px;zoom:1", support.inlineBlockNeedsLayout = val = div.offsetWidth === 3, val && (body.style.zoom = 1)), body.removeChild(container);
    }), function() {
        var div = document.createElement("div");
        if (support.deleteExpando == null) {
            support.deleteExpando = !0;
            try {
                delete 
div.test;
            } catch (e) {
                support.deleteExpando = !1;
            }
        }
        div = null;
    }(), jQuery.acceptData = function(elem) {
        var noData = jQuery.noData[(elem.nodeName + " ").toLowerCase()], nodeType = +elem.nodeType || 1;
        return nodeType !== 1 && nodeType !== 9 ? !1 : !noData || noData !== !0 && elem.getAttribute("classid") === noData;
    };
    var rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, rmultiDash = /([A-Z])/g;
    function dataAttr(elem, key, data) {
        if (data === undefined && elem.nodeType === 1) {
            var name = "data-" + key.replace(rmultiDash, "-$1").toLowerCase();
            data = elem.getAttribute(name);
            if (typeof data == "string") {
                try {
                    data = data === "true" ? !0 : data === "false" ? !1 : data === "null" ? null : +data + "" === data ? +data : rbrace.test(data) ? jQuery.parseJSON(data) : data;
                } catch (e) {}
                jQuery.
data(elem, key, data);
            } else data = undefined;
        }
        return data;
    }
    function isEmptyDataObject(obj) {
        var name;
        for (name in obj) {
            if (name === "data" && jQuery.isEmptyObject(obj[name])) continue;
            if (name !== "toJSON") return !1;
        }
        return !0;
    }
    function internalData(elem, name, data, pvt) {
        if (!jQuery.acceptData(elem)) return;
        var ret, thisCache, internalKey = jQuery.expando, isNode = elem.nodeType, cache = isNode ? jQuery.cache : elem, id = isNode ? elem[internalKey] : elem[internalKey] && internalKey;
        if ((!id || !cache[id] || !pvt && !cache[id].data) && data === undefined && typeof name == "string") return;
        id || (isNode ? id = elem[internalKey] = deletedIds.pop() || jQuery.guid++ : id = internalKey), cache[id] || (cache[id] = isNode ? {} : {
            toJSON: jQuery.noop
        });
        if (typeof name == "object" || typeof name == "function") pvt ? 
cache[id] = jQuery.extend(cache[id], name) : cache[id].data = jQuery.extend(cache[id].data, name);
        return thisCache = cache[id], pvt || (thisCache.data || (thisCache.data = {}), thisCache = thisCache.data), data !== undefined && (thisCache[jQuery.camelCase(name)] = data), typeof name == "string" ? (ret = thisCache[name], ret == null && (ret = thisCache[jQuery.camelCase(name)])) : ret = thisCache, ret;
    }
    function internalRemoveData(elem, name, pvt) {
        if (!jQuery.acceptData(elem)) return;
        var thisCache, i, isNode = elem.nodeType, cache = isNode ? jQuery.cache : elem, id = isNode ? elem[jQuery.expando] : jQuery.expando;
        if (!cache[id]) return;
        if (name) {
            thisCache = pvt ? cache[id] : cache[id].data;
            if (thisCache) {
                jQuery.isArray(name) ? name = name.concat(jQuery.map(name, jQuery.camelCase)) : name in thisCache ? name = [ name ] : (name = jQuery.camelCase(name), name in thisCache ? name = [ name ] : name = 
name.split(" ")), i = name.length;
                while (i--) delete thisCache[name[i]];
                if (pvt ? !isEmptyDataObject(thisCache) : !jQuery.isEmptyObject(thisCache)) return;
            }
        }
        if (!pvt) {
            delete cache[id].data;
            if (!isEmptyDataObject(cache[id])) return;
        }
        isNode ? jQuery.cleanData([ elem ], !0) : support.deleteExpando || cache != cache.window ? delete cache[id] : cache[id] = null;
    }
    jQuery.extend({
        cache: {},
        noData: {
            "applet ": !0,
            "embed ": !0,
            "object ": "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
        },
        hasData: function(elem) {
            return elem = elem.nodeType ? jQuery.cache[elem[jQuery.expando]] : elem[jQuery.expando], !!elem && !isEmptyDataObject(elem);
        },
        data: function(elem, name, data) {
            return internalData(elem, name, data);
        },
        removeData: function(elem, name) {
            
return internalRemoveData(elem, name);
        },
        _data: function(elem, name, data) {
            return internalData(elem, name, data, !0);
        },
        _removeData: function(elem, name) {
            return internalRemoveData(elem, name, !0);
        }
    }), jQuery.fn.extend({
        data: function(key, value) {
            var i, name, data, elem = this[0], attrs = elem && elem.attributes;
            if (key === undefined) {
                if (this.length) {
                    data = jQuery.data(elem);
                    if (elem.nodeType === 1 && !jQuery._data(elem, "parsedAttrs")) {
                        i = attrs.length;
                        while (i--) attrs[i] && (name = attrs[i].name, name.indexOf("data-") === 0 && (name = jQuery.camelCase(name.slice(5)), dataAttr(elem, name, data[name])));
                        jQuery._data(elem, "parsedAttrs", !0);
                    }
                }
                return data;
            }
            return typeof 
key == "object" ? this.each(function() {
                jQuery.data(this, key);
            }) : arguments.length > 1 ? this.each(function() {
                jQuery.data(this, key, value);
            }) : elem ? dataAttr(elem, key, jQuery.data(elem, key)) : undefined;
        },
        removeData: function(key) {
            return this.each(function() {
                jQuery.removeData(this, key);
            });
        }
    }), jQuery.extend({
        queue: function(elem, type, data) {
            var queue;
            if (elem) return type = (type || "fx") + "queue", queue = jQuery._data(elem, type), data && (!queue || jQuery.isArray(data) ? queue = jQuery._data(elem, type, jQuery.makeArray(data)) : queue.push(data)), queue || [];
        },
        dequeue: function(elem, type) {
            type = type || "fx";
            var queue = jQuery.queue(elem, type), startLength = queue.length, fn = queue.shift(), hooks = jQuery._queueHooks(elem, type), next = function() {
                
jQuery.dequeue(elem, type);
            };
            fn === "inprogress" && (fn = queue.shift(), startLength--), fn && (type === "fx" && queue.unshift("inprogress"), delete hooks.stop, fn.call(elem, next, hooks)), !startLength && hooks && hooks.empty.fire();
        },
        _queueHooks: function(elem, type) {
            var key = type + "queueHooks";
            return jQuery._data(elem, key) || jQuery._data(elem, key, {
                empty: jQuery.Callbacks("once memory").add(function() {
                    jQuery._removeData(elem, type + "queue"), jQuery._removeData(elem, key);
                })
            });
        }
    }), jQuery.fn.extend({
        queue: function(type, data) {
            var setter = 2;
            return typeof type != "string" && (data = type, type = "fx", setter--), arguments.length < setter ? jQuery.queue(this[0], type) : data === undefined ? this : this.each(function() {
                var queue = jQuery.queue(this, type, data);
                
jQuery._queueHooks(this, type), type === "fx" && queue[0] !== "inprogress" && jQuery.dequeue(this, type);
            });
        },
        dequeue: function(type) {
            return this.each(function() {
                jQuery.dequeue(this, type);
            });
        },
        clearQueue: function(type) {
            return this.queue(type || "fx", []);
        },
        promise: function(type, obj) {
            var tmp, count = 1, defer = jQuery.Deferred(), elements = this, i = this.length, resolve = function() {
                --count || defer.resolveWith(elements, [ elements ]);
            };
            typeof type != "string" && (obj = type, type = undefined), type = type || "fx";
            while (i--) tmp = jQuery._data(elements[i], type + "queueHooks"), tmp && tmp.empty && (count++, tmp.empty.add(resolve));
            return resolve(), defer.promise(obj);
        }
    });
    var pnum = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, cssExpand = [ "Top", "Right", "Bottom"
, "Left" ], isHidden = function(elem, el) {
        return elem = el || elem, jQuery.css(elem, "display") === "none" || !jQuery.contains(elem.ownerDocument, elem);
    }, access = jQuery.access = function(elems, fn, key, value, chainable, emptyGet, raw) {
        var i = 0, length = elems.length, bulk = key == null;
        if (jQuery.type(key) === "object") {
            chainable = !0;
            for (i in key) jQuery.access(elems, fn, i, key[i], !0, emptyGet, raw);
        } else if (value !== undefined) {
            chainable = !0, jQuery.isFunction(value) || (raw = !0), bulk && (raw ? (fn.call(elems, value), fn = null) : (bulk = fn, fn = function(elem, key, value) {
                return bulk.call(jQuery(elem), value);
            }));
            if (fn) for (; i < length; i++) fn(elems[i], key, raw ? value : value.call(elems[i], i, fn(elems[i], key)));
        }
        return chainable ? elems : bulk ? fn.call(elems) : length ? fn(elems[0], key) : emptyGet;
    }, rcheckableType = /^(?:checkbox|radio)$/i
;
    (function() {
        var input = document.createElement("input"), div = document.createElement("div"), fragment = document.createDocumentFragment();
        div.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", support.leadingWhitespace = div.firstChild.nodeType === 3, support.tbody = !div.getElementsByTagName("tbody").length, support.htmlSerialize = !!div.getElementsByTagName("link").length, support.html5Clone = document.createElement("nav").cloneNode(!0).outerHTML !== "<:nav></:nav>", input.type = "checkbox", input.checked = !0, fragment.appendChild(input), support.appendChecked = input.checked, div.innerHTML = "<textarea>x</textarea>", support.noCloneChecked = !!div.cloneNode(!0).lastChild.defaultValue, fragment.appendChild(div), div.innerHTML = "<input type='radio' checked='checked' name='t'/>", support.checkClone = div.cloneNode(!0).cloneNode(!0).lastChild.checked, support.noCloneEvent = !0, div.attachEvent && (div.attachEvent("onclick", function(
) {
            support.noCloneEvent = !1;
        }), div.cloneNode(!0).click());
        if (support.deleteExpando == null) {
            support.deleteExpando = !0;
            try {
                delete div.test;
            } catch (e) {
                support.deleteExpando = !1;
            }
        }
    })(), function() {
        var i, eventName, div = document.createElement("div");
        for (i in {
            submit: !0,
            change: !0,
            focusin: !0
        }) eventName = "on" + i, (support[i + "Bubbles"] = eventName in window) || (div.setAttribute(eventName, "t"), support[i + "Bubbles"] = div.attributes[eventName].expando === !1);
        div = null;
    }();
    var rformElems = /^(?:input|select|textarea)$/i, rkeyEvent = /^key/, rmouseEvent = /^(?:mouse|pointer|contextmenu)|click/, rfocusMorph = /^(?:focusinfocus|focusoutblur)$/, rtypenamespace = /^([^.]*)(?:\.(.+)|)$/;
    function returnTrue() {
        return !0;
    }
    function returnFalse(
) {
        return !1;
    }
    function safeActiveElement() {
        try {
            return document.activeElement;
        } catch (err) {}
    }
    jQuery.event = {
        global: {},
        add: function(elem, types, handler, data, selector) {
            var tmp, events, t, handleObjIn, special, eventHandle, handleObj, handlers, type, namespaces, origType, elemData = jQuery._data(elem);
            if (!elemData) return;
            handler.handler && (handleObjIn = handler, handler = handleObjIn.handler, selector = handleObjIn.selector), handler.guid || (handler.guid = jQuery.guid++), (events = elemData.events) || (events = elemData.events = {}), (eventHandle = elemData.handle) || (eventHandle = elemData.handle = function(e) {
                return typeof jQuery === strundefined || !!e && jQuery.event.triggered === e.type ? undefined : jQuery.event.dispatch.apply(eventHandle.elem, arguments);
            }, eventHandle.elem = elem), types = (types || "").match(rnotwhite) || 
[ "" ], t = types.length;
            while (t--) {
                tmp = rtypenamespace.exec(types[t]) || [], type = origType = tmp[1], namespaces = (tmp[2] || "").split(".").sort();
                if (!type) continue;
                special = jQuery.event.special[type] || {}, type = (selector ? special.delegateType : special.bindType) || type, special = jQuery.event.special[type] || {}, handleObj = jQuery.extend({
                    type: type,
                    origType: origType,
                    data: data,
                    handler: handler,
                    guid: handler.guid,
                    selector: selector,
                    needsContext: selector && jQuery.expr.match.needsContext.test(selector),
                    namespace: namespaces.join(".")
                }, handleObjIn);
                if (!(handlers = events[type])) {
                    handlers = events[type] = [], handlers.delegateCount = 0;
                    if (!special.setup || special.setup
.call(elem, data, namespaces, eventHandle) === !1) elem.addEventListener ? elem.addEventListener(type, eventHandle, !1) : elem.attachEvent && elem.attachEvent("on" + type, eventHandle);
                }
                special.add && (special.add.call(elem, handleObj), handleObj.handler.guid || (handleObj.handler.guid = handler.guid)), selector ? handlers.splice(handlers.delegateCount++, 0, handleObj) : handlers.push(handleObj), jQuery.event.global[type] = !0;
            }
            elem = null;
        },
        remove: function(elem, types, handler, selector, mappedTypes) {
            var j, handleObj, tmp, origCount, t, events, special, handlers, type, namespaces, origType, elemData = jQuery.hasData(elem) && jQuery._data(elem);
            if (!elemData || !(events = elemData.events)) return;
            types = (types || "").match(rnotwhite) || [ "" ], t = types.length;
            while (t--) {
                tmp = rtypenamespace.exec(types[t]) || [], type = origType = tmp[1
], namespaces = (tmp[2] || "").split(".").sort();
                if (!type) {
                    for (type in events) jQuery.event.remove(elem, type + types[t], handler, selector, !0);
                    continue;
                }
                special = jQuery.event.special[type] || {}, type = (selector ? special.delegateType : special.bindType) || type, handlers = events[type] || [], tmp = tmp[2] && new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)"), origCount = j = handlers.length;
                while (j--) handleObj = handlers[j], (mappedTypes || origType === handleObj.origType) && (!handler || handler.guid === handleObj.guid) && (!tmp || tmp.test(handleObj.namespace)) && (!selector || selector === handleObj.selector || selector === "**" && handleObj.selector) && (handlers.splice(j, 1), handleObj.selector && handlers.delegateCount--, special.remove && special.remove.call(elem, handleObj));
                origCount && !handlers.length && ((!special.teardown || 
special.teardown.call(elem, namespaces, elemData.handle) === !1) && jQuery.removeEvent(elem, type, elemData.handle), delete events[type]);
            }
            jQuery.isEmptyObject(events) && (delete elemData.handle, jQuery._removeData(elem, "events"));
        },
        trigger: function(event, data, elem, onlyHandlers) {
            var handle, ontype, cur, bubbleType, special, tmp, i, eventPath = [ elem || document ], type = hasOwn.call(event, "type") ? event.type : event, namespaces = hasOwn.call(event, "namespace") ? event.namespace.split(".") : [];
            cur = tmp = elem = elem || document;
            if (elem.nodeType === 3 || elem.nodeType === 8) return;
            if (rfocusMorph.test(type + jQuery.event.triggered)) return;
            type.indexOf(".") >= 0 && (namespaces = type.split("."), type = namespaces.shift(), namespaces.sort()), ontype = type.indexOf(":") < 0 && "on" + type, event = event[jQuery.expando] ? event : new jQuery.Event(type, typeof event == "object" && 
event), event.isTrigger = onlyHandlers ? 2 : 3, event.namespace = namespaces.join("."), event.namespace_re = event.namespace ? new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, event.result = undefined, event.target || (event.target = elem), data = data == null ? [ event ] : jQuery.makeArray(data, [ event ]), special = jQuery.event.special[type] || {};
            if (!onlyHandlers && special.trigger && special.trigger.apply(elem, data) === !1) return;
            if (!onlyHandlers && !special.noBubble && !jQuery.isWindow(elem)) {
                bubbleType = special.delegateType || type, rfocusMorph.test(bubbleType + type) || (cur = cur.parentNode);
                for (; cur; cur = cur.parentNode) eventPath.push(cur), tmp = cur;
                tmp === (elem.ownerDocument || document) && eventPath.push(tmp.defaultView || tmp.parentWindow || window);
            }
            i = 0;
            while ((cur = eventPath[i++]) && !event.isPropagationStopped()) event
.type = i > 1 ? bubbleType : special.bindType || type, handle = (jQuery._data(cur, "events") || {})[event.type] && jQuery._data(cur, "handle"), handle && handle.apply(cur, data), handle = ontype && cur[ontype], handle && handle.apply && jQuery.acceptData(cur) && (event.result = handle.apply(cur, data), event.result === !1 && event.preventDefault());
            event.type = type;
            if (!onlyHandlers && !event.isDefaultPrevented() && (!special._default || special._default.apply(eventPath.pop(), data) === !1) && jQuery.acceptData(elem) && ontype && elem[type] && !jQuery.isWindow(elem)) {
                tmp = elem[ontype], tmp && (elem[ontype] = null), jQuery.event.triggered = type;
                try {
                    elem[type]();
                } catch (e) {}
                jQuery.event.triggered = undefined, tmp && (elem[ontype] = tmp);
            }
            return event.result;
        },
        dispatch: function(event) {
            event = jQuery.event.fix(event
);
            var i, ret, handleObj, matched, j, handlerQueue = [], args = slice.call(arguments), handlers = (jQuery._data(this, "events") || {})[event.type] || [], special = jQuery.event.special[event.type] || {};
            args[0] = event, event.delegateTarget = this;
            if (special.preDispatch && special.preDispatch.call(this, event) === !1) return;
            handlerQueue = jQuery.event.handlers.call(this, event, handlers), i = 0;
            while ((matched = handlerQueue[i++]) && !event.isPropagationStopped()) {
                event.currentTarget = matched.elem, j = 0;
                while ((handleObj = matched.handlers[j++]) && !event.isImmediatePropagationStopped()) if (!event.namespace_re || event.namespace_re.test(handleObj.namespace)) event.handleObj = handleObj, event.data = handleObj.data, ret = ((jQuery.event.special[handleObj.origType] || {}).handle || handleObj.handler).apply(matched.elem, args), ret !== undefined && (event.result = ret) === !1 && (event.preventDefault
(), event.stopPropagation());
            }
            return special.postDispatch && special.postDispatch.call(this, event), event.result;
        },
        handlers: function(event, handlers) {
            var sel, handleObj, matches, i, handlerQueue = [], delegateCount = handlers.delegateCount, cur = event.target;
            if (delegateCount && cur.nodeType && (!event.button || event.type !== "click")) for (; cur != this; cur = cur.parentNode || this) if (cur.nodeType === 1 && (cur.disabled !== !0 || event.type !== "click")) {
                matches = [];
                for (i = 0; i < delegateCount; i++) handleObj = handlers[i], sel = handleObj.selector + " ", matches[sel] === undefined && (matches[sel] = handleObj.needsContext ? jQuery(sel, this).index(cur) >= 0 : jQuery.find(sel, this, null, [ cur ]).length), matches[sel] && matches.push(handleObj);
                matches.length && handlerQueue.push({
                    elem: cur,
                    handlers: matches
                
});
            }
            return delegateCount < handlers.length && handlerQueue.push({
                elem: this,
                handlers: handlers.slice(delegateCount)
            }), handlerQueue;
        },
        fix: function(event) {
            if (event[jQuery.expando]) return event;
            var i, prop, copy, type = event.type, originalEvent = event, fixHook = this.fixHooks[type];
            fixHook || (this.fixHooks[type] = fixHook = rmouseEvent.test(type) ? this.mouseHooks : rkeyEvent.test(type) ? this.keyHooks : {}), copy = fixHook.props ? this.props.concat(fixHook.props) : this.props, event = new jQuery.Event(originalEvent), i = copy.length;
            while (i--) prop = copy[i], event[prop] = originalEvent[prop];
            return event.target || (event.target = originalEvent.srcElement || document), event.target.nodeType === 3 && (event.target = event.target.parentNode), event.metaKey = !!event.metaKey, fixHook.filter ? fixHook.filter(event, originalEvent) 
: event;
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "),
            filter: function(event, original) {
                return event.which == null && (event.which = original.charCode != null ? original.charCode : original.keyCode), event;
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function(event, original) {
                var body, eventDoc, doc, button = original.button, fromElement = original.fromElement;
                return event.pageX == null && original.clientX != null && (eventDoc = event.target.ownerDocument || document, doc = eventDoc.documentElement, body = eventDoc.body, event.pageX = original.clientX + (doc && doc
.scrollLeft || body && body.scrollLeft || 0) - (doc && doc.clientLeft || body && body.clientLeft || 0), event.pageY = original.clientY + (doc && doc.scrollTop || body && body.scrollTop || 0) - (doc && doc.clientTop || body && body.clientTop || 0)), !event.relatedTarget && fromElement && (event.relatedTarget = fromElement === event.target ? original.toElement : fromElement), !event.which && button !== undefined && (event.which = button & 1 ? 1 : button & 2 ? 3 : button & 4 ? 2 : 0), event;
            }
        },
        special: {
            load: {
                noBubble: !0
            },
            focus: {
                trigger: function() {
                    if (this !== safeActiveElement() && this.focus) try {
                        return this.focus(), !1;
                    } catch (e) {}
                },
                delegateType: "focusin"
            },
            blur: {
                trigger: function() {
                    if (this === safeActiveElement
() && this.blur) return this.blur(), !1;
                },
                delegateType: "focusout"
            },
            click: {
                trigger: function() {
                    if (jQuery.nodeName(this, "input") && this.type === "checkbox" && this.click) return this.click(), !1;
                },
                _default: function(event) {
                    return jQuery.nodeName(event.target, "a");
                }
            },
            beforeunload: {
                postDispatch: function(event) {
                    event.result !== undefined && event.originalEvent && (event.originalEvent.returnValue = event.result);
                }
            }
        },
        simulate: function(type, elem, event, bubble) {
            var e = jQuery.extend(new jQuery.Event, event, {
                type: type,
                isSimulated: !0,
                originalEvent: {}
            });
            bubble ? jQuery.event.trigger(e, null, elem) : jQuery.event.dispatch
.call(elem, e), e.isDefaultPrevented() && event.preventDefault();
        }
    }, jQuery.removeEvent = document.removeEventListener ? function(elem, type, handle) {
        elem.removeEventListener && elem.removeEventListener(type, handle, !1);
    } : function(elem, type, handle) {
        var name = "on" + type;
        elem.detachEvent && (typeof elem[name] === strundefined && (elem[name] = null), elem.detachEvent(name, handle));
    }, jQuery.Event = function(src, props) {
        if (!(this instanceof jQuery.Event)) return new jQuery.Event(src, props);
        src && src.type ? (this.originalEvent = src, this.type = src.type, this.isDefaultPrevented = src.defaultPrevented || src.defaultPrevented === undefined && src.returnValue === !1 ? returnTrue : returnFalse) : this.type = src, props && jQuery.extend(this, props), this.timeStamp = src && src.timeStamp || jQuery.now(), this[jQuery.expando] = !0;
    }, jQuery.Event.prototype = {
        isDefaultPrevented: returnFalse,
        isPropagationStopped
: returnFalse,
        isImmediatePropagationStopped: returnFalse,
        preventDefault: function() {
            var e = this.originalEvent;
            this.isDefaultPrevented = returnTrue;
            if (!e) return;
            e.preventDefault ? e.preventDefault() : e.returnValue = !1;
        },
        stopPropagation: function() {
            var e = this.originalEvent;
            this.isPropagationStopped = returnTrue;
            if (!e) return;
            e.stopPropagation && e.stopPropagation(), e.cancelBubble = !0;
        },
        stopImmediatePropagation: function() {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = returnTrue, e && e.stopImmediatePropagation && e.stopImmediatePropagation(), this.stopPropagation();
        }
    }, jQuery.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function(orig, fix) {
        jQuery.event
.special[orig] = {
            delegateType: fix,
            bindType: fix,
            handle: function(event) {
                var ret, target = this, related = event.relatedTarget, handleObj = event.handleObj;
                if (!related || related !== target && !jQuery.contains(target, related)) event.type = handleObj.origType, ret = handleObj.handler.apply(this, arguments), event.type = fix;
                return ret;
            }
        };
    }), support.submitBubbles || (jQuery.event.special.submit = {
        setup: function() {
            if (jQuery.nodeName(this, "form")) return !1;
            jQuery.event.add(this, "click._submit keypress._submit", function(e) {
                var elem = e.target, form = jQuery.nodeName(elem, "input") || jQuery.nodeName(elem, "button") ? elem.form : undefined;
                form && !jQuery._data(form, "submitBubbles") && (jQuery.event.add(form, "submit._submit", function(event) {
                    event._submit_bubble = !0;
                
}), jQuery._data(form, "submitBubbles", !0));
            });
        },
        postDispatch: function(event) {
            event._submit_bubble && (delete event._submit_bubble, this.parentNode && !event.isTrigger && jQuery.event.simulate("submit", this.parentNode, event, !0));
        },
        teardown: function() {
            if (jQuery.nodeName(this, "form")) return !1;
            jQuery.event.remove(this, "._submit");
        }
    }), support.changeBubbles || (jQuery.event.special.change = {
        setup: function() {
            if (rformElems.test(this.nodeName)) {
                if (this.type === "checkbox" || this.type === "radio") jQuery.event.add(this, "propertychange._change", function(event) {
                    event.originalEvent.propertyName === "checked" && (this._just_changed = !0);
                }), jQuery.event.add(this, "click._change", function(event) {
                    this._just_changed && !event.isTrigger && (this._just_changed = !1), jQuery.event.simulate
("change", this, event, !0);
                });
                return !1;
            }
            jQuery.event.add(this, "beforeactivate._change", function(e) {
                var elem = e.target;
                rformElems.test(elem.nodeName) && !jQuery._data(elem, "changeBubbles") && (jQuery.event.add(elem, "change._change", function(event) {
                    this.parentNode && !event.isSimulated && !event.isTrigger && jQuery.event.simulate("change", this.parentNode, event, !0);
                }), jQuery._data(elem, "changeBubbles", !0));
            });
        },
        handle: function(event) {
            var elem = event.target;
            if (this !== elem || event.isSimulated || event.isTrigger || elem.type !== "radio" && elem.type !== "checkbox") return event.handleObj.handler.apply(this, arguments);
        },
        teardown: function() {
            return jQuery.event.remove(this, "._change"), !rformElems.test(this.nodeName);
        }
    }), support.focusinBubbles || 
jQuery.each({
        focus: "focusin",
        blur: "focusout"
    }, function(orig, fix) {
        var handler = function(event) {
            jQuery.event.simulate(fix, event.target, jQuery.event.fix(event), !0);
        };
        jQuery.event.special[fix] = {
            setup: function() {
                var doc = this.ownerDocument || this, attaches = jQuery._data(doc, fix);
                attaches || doc.addEventListener(orig, handler, !0), jQuery._data(doc, fix, (attaches || 0) + 1);
            },
            teardown: function() {
                var doc = this.ownerDocument || this, attaches = jQuery._data(doc, fix) - 1;
                attaches ? jQuery._data(doc, fix, attaches) : (doc.removeEventListener(orig, handler, !0), jQuery._removeData(doc, fix));
            }
        };
    }), jQuery.fn.extend({
        on: function(types, selector, data, fn, one) {
            var type, origFn;
            if (typeof types == "object") {
                typeof selector != "string" && 
(data = data || selector, selector = undefined);
                for (type in types) this.on(type, selector, data, types[type], one);
                return this;
            }
            data == null && fn == null ? (fn = selector, data = selector = undefined) : fn == null && (typeof selector == "string" ? (fn = data, data = undefined) : (fn = data, data = selector, selector = undefined));
            if (fn === !1) fn = returnFalse; else if (!fn) return this;
            return one === 1 && (origFn = fn, fn = function(event) {
                return jQuery().off(event), origFn.apply(this, arguments);
            }, fn.guid = origFn.guid || (origFn.guid = jQuery.guid++)), this.each(function() {
                jQuery.event.add(this, types, fn, data, selector);
            });
        },
        one: function(types, selector, data, fn) {
            return this.on(types, selector, data, fn, 1);
        },
        off: function(types, selector, fn) {
            var handleObj, type;
            
if (types && types.preventDefault && types.handleObj) return handleObj = types.handleObj, jQuery(types.delegateTarget).off(handleObj.namespace ? handleObj.origType + "." + handleObj.namespace : handleObj.origType, handleObj.selector, handleObj.handler), this;
            if (typeof types == "object") {
                for (type in types) this.off(type, selector, types[type]);
                return this;
            }
            if (selector === !1 || typeof selector == "function") fn = selector, selector = undefined;
            return fn === !1 && (fn = returnFalse), this.each(function() {
                jQuery.event.remove(this, types, fn, selector);
            });
        },
        trigger: function(type, data) {
            return this.each(function() {
                jQuery.event.trigger(type, data, this);
            });
        },
        triggerHandler: function(type, data) {
            var elem = this[0];
            if (elem) return jQuery.event.trigger(type, data, elem
, !0);
        }
    });
    function createSafeFragment(document) {
        var list = nodeNames.split("|"), safeFrag = document.createDocumentFragment();
        if (safeFrag.createElement) while (list.length) safeFrag.createElement(list.pop());
        return safeFrag;
    }
    var nodeNames = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video", rinlinejQuery = / jQuery\d+="(?:null|\d+)"/g, rnoshimcache = new RegExp("<(?:" + nodeNames + ")[\\s/>]", "i"), rleadingWhitespace = /^\s+/, rxhtmlTag = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi, rtagName = /<([\w:]+)/, rtbody = /<tbody/i, rhtml = /<|&#?\w+;/, rnoInnerhtml = /<(?:script|style|link)/i, rchecked = /checked\s*(?:[^=]|=\s*.checked.)/i, rscriptType = /^$|\/(?:java|ecma)script/i, rscriptTypeMasked = /^true\/(.*)/, rcleanScript = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g, wrapMap = {
        option
: [ 1, "<select multiple='multiple'>", "</select>" ],
        legend: [ 1, "<fieldset>", "</fieldset>" ],
        area: [ 1, "<map>", "</map>" ],
        param: [ 1, "<object>", "</object>" ],
        thead: [ 1, "<table>", "</table>" ],
        tr: [ 2, "<table><tbody>", "</tbody></table>" ],
        col: [ 2, "<table><tbody></tbody><colgroup>", "</colgroup></table>" ],
        td: [ 3, "<table><tbody><tr>", "</tr></tbody></table>" ],
        _default: support.htmlSerialize ? [ 0, "", "" ] : [ 1, "X<div>", "</div>" ]
    }, safeFragment = createSafeFragment(document), fragmentDiv = safeFragment.appendChild(document.createElement("div"));
    wrapMap.optgroup = wrapMap.option, wrapMap.tbody = wrapMap.tfoot = wrapMap.colgroup = wrapMap.caption = wrapMap.thead, wrapMap.th = wrapMap.td;
    function getAll(context, tag) {
        var elems, elem, i = 0, found = typeof context.getElementsByTagName !== strundefined ? context.getElementsByTagName(tag || "*") : typeof context.querySelectorAll !== 
strundefined ? context.querySelectorAll(tag || "*") : undefined;
        if (!found) for (found = [], elems = context.childNodes || context; (elem = elems[i]) != null; i++) !tag || jQuery.nodeName(elem, tag) ? found.push(elem) : jQuery.merge(found, getAll(elem, tag));
        return tag === undefined || tag && jQuery.nodeName(context, tag) ? jQuery.merge([ context ], found) : found;
    }
    function fixDefaultChecked(elem) {
        rcheckableType.test(elem.type) && (elem.defaultChecked = elem.checked);
    }
    function manipulationTarget(elem, content) {
        return jQuery.nodeName(elem, "table") && jQuery.nodeName(content.nodeType !== 11 ? content : content.firstChild, "tr") ? elem.getElementsByTagName("tbody")[0] || elem.appendChild(elem.ownerDocument.createElement("tbody")) : elem;
    }
    function disableScript(elem) {
        return elem.type = (jQuery.find.attr(elem, "type") !== null) + "/" + elem.type, elem;
    }
    function restoreScript(elem) {
        var match = rscriptTypeMasked
.exec(elem.type);
        return match ? elem.type = match[1] : elem.removeAttribute("type"), elem;
    }
    function setGlobalEval(elems, refElements) {
        var elem, i = 0;
        for (; (elem = elems[i]) != null; i++) jQuery._data(elem, "globalEval", !refElements || jQuery._data(refElements[i], "globalEval"));
    }
    function cloneCopyEvent(src, dest) {
        if (dest.nodeType !== 1 || !jQuery.hasData(src)) return;
        var type, i, l, oldData = jQuery._data(src), curData = jQuery._data(dest, oldData), events = oldData.events;
        if (events) {
            delete curData.handle, curData.events = {};
            for (type in events) for (i = 0, l = events[type].length; i < l; i++) jQuery.event.add(dest, type, events[type][i]);
        }
        curData.data && (curData.data = jQuery.extend({}, curData.data));
    }
    function fixCloneNodeIssues(src, dest) {
        var nodeName, e, data;
        if (dest.nodeType !== 1) return;
        nodeName = dest.nodeName.toLowerCase
();
        if (!support.noCloneEvent && dest[jQuery.expando]) {
            data = jQuery._data(dest);
            for (e in data.events) jQuery.removeEvent(dest, e, data.handle);
            dest.removeAttribute(jQuery.expando);
        }
        if (nodeName === "script" && dest.text !== src.text) disableScript(dest).text = src.text, restoreScript(dest); else if (nodeName === "object") dest.parentNode && (dest.outerHTML = src.outerHTML), support.html5Clone && src.innerHTML && !jQuery.trim(dest.innerHTML) && (dest.innerHTML = src.innerHTML); else if (nodeName === "input" && rcheckableType.test(src.type)) dest.defaultChecked = dest.checked = src.checked, dest.value !== src.value && (dest.value = src.value); else if (nodeName === "option") dest.defaultSelected = dest.selected = src.defaultSelected; else if (nodeName === "input" || nodeName === "textarea") dest.defaultValue = src.defaultValue;
    }
    jQuery.extend({
        clone: function(elem, dataAndEvents, deepDataAndEvents) {
            
var destElements, node, clone, i, srcElements, inPage = jQuery.contains(elem.ownerDocument, elem);
            support.html5Clone || jQuery.isXMLDoc(elem) || !rnoshimcache.test("<" + elem.nodeName + ">") ? clone = elem.cloneNode(!0) : (fragmentDiv.innerHTML = elem.outerHTML, fragmentDiv.removeChild(clone = fragmentDiv.firstChild));
            if ((!support.noCloneEvent || !support.noCloneChecked) && (elem.nodeType === 1 || elem.nodeType === 11) && !jQuery.isXMLDoc(elem)) {
                destElements = getAll(clone), srcElements = getAll(elem);
                for (i = 0; (node = srcElements[i]) != null; ++i) destElements[i] && fixCloneNodeIssues(node, destElements[i]);
            }
            if (dataAndEvents) if (deepDataAndEvents) {
                srcElements = srcElements || getAll(elem), destElements = destElements || getAll(clone);
                for (i = 0; (node = srcElements[i]) != null; i++) cloneCopyEvent(node, destElements[i]);
            } else cloneCopyEvent(elem, 
clone);
            return destElements = getAll(clone, "script"), destElements.length > 0 && setGlobalEval(destElements, !inPage && getAll(elem, "script")), destElements = srcElements = node = null, clone;
        },
        buildFragment: function(elems, context, scripts, selection) {
            var j, elem, contains, tmp, tag, tbody, wrap, l = elems.length, safe = createSafeFragment(context), nodes = [], i = 0;
            for (; i < l; i++) {
                elem = elems[i];
                if (elem || elem === 0) if (jQuery.type(elem) === "object") jQuery.merge(nodes, elem.nodeType ? [ elem ] : elem); else if (!rhtml.test(elem)) nodes.push(context.createTextNode(elem)); else {
                    tmp = tmp || safe.appendChild(context.createElement("div")), tag = (rtagName.exec(elem) || [ "", "" ])[1].toLowerCase(), wrap = wrapMap[tag] || wrapMap._default, tmp.innerHTML = wrap[1] + elem.replace(rxhtmlTag, "<$1></$2>") + wrap[2], j = wrap[0];
                    while (j--) tmp = tmp
.lastChild;
                    !support.leadingWhitespace && rleadingWhitespace.test(elem) && nodes.push(context.createTextNode(rleadingWhitespace.exec(elem)[0]));
                    if (!support.tbody) {
                        elem = tag === "table" && !rtbody.test(elem) ? tmp.firstChild : wrap[1] === "<table>" && !rtbody.test(elem) ? tmp : 0, j = elem && elem.childNodes.length;
                        while (j--) jQuery.nodeName(tbody = elem.childNodes[j], "tbody") && !tbody.childNodes.length && elem.removeChild(tbody);
                    }
                    jQuery.merge(nodes, tmp.childNodes), tmp.textContent = "";
                    while (tmp.firstChild) tmp.removeChild(tmp.firstChild);
                    tmp = safe.lastChild;
                }
            }
            tmp && safe.removeChild(tmp), support.appendChecked || jQuery.grep(getAll(nodes, "input"), fixDefaultChecked), i = 0;
            while (elem = nodes[i++]) {
                if (selection && jQuery.inArray(elem
, selection) !== -1) continue;
                contains = jQuery.contains(elem.ownerDocument, elem), tmp = getAll(safe.appendChild(elem), "script"), contains && setGlobalEval(tmp);
                if (scripts) {
                    j = 0;
                    while (elem = tmp[j++]) rscriptType.test(elem.type || "") && scripts.push(elem);
                }
            }
            return tmp = null, safe;
        },
        cleanData: function(elems, acceptData) {
            var elem, type, id, data, i = 0, internalKey = jQuery.expando, cache = jQuery.cache, deleteExpando = support.deleteExpando, special = jQuery.event.special;
            for (; (elem = elems[i]) != null; i++) if (acceptData || jQuery.acceptData(elem)) {
                id = elem[internalKey], data = id && cache[id];
                if (data) {
                    if (data.events) for (type in data.events) special[type] ? jQuery.event.remove(elem, type) : jQuery.removeEvent(elem, type, data.handle);
                    
cache[id] && (delete cache[id], deleteExpando ? delete elem[internalKey] : typeof elem.removeAttribute !== strundefined ? elem.removeAttribute(internalKey) : elem[internalKey] = null, deletedIds.push(id));
                }
            }
        }
    }), jQuery.fn.extend({
        text: function(value) {
            return access(this, function(value) {
                return value === undefined ? jQuery.text(this) : this.empty().append((this[0] && this[0].ownerDocument || document).createTextNode(value));
            }, null, value, arguments.length);
        },
        append: function() {
            return this.domManip(arguments, function(elem) {
                if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
                    var target = manipulationTarget(this, elem);
                    target.appendChild(elem);
                }
            });
        },
        prepend: function() {
            return this.domManip(arguments, function(elem) {
                
if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
                    var target = manipulationTarget(this, elem);
                    target.insertBefore(elem, target.firstChild);
                }
            });
        },
        before: function() {
            return this.domManip(arguments, function(elem) {
                this.parentNode && this.parentNode.insertBefore(elem, this);
            });
        },
        after: function() {
            return this.domManip(arguments, function(elem) {
                this.parentNode && this.parentNode.insertBefore(elem, this.nextSibling);
            });
        },
        remove: function(selector, keepData) {
            var elem, elems = selector ? jQuery.filter(selector, this) : this, i = 0;
            for (; (elem = elems[i]) != null; i++) !keepData && elem.nodeType === 1 && jQuery.cleanData(getAll(elem)), elem.parentNode && (keepData && jQuery.contains(elem.ownerDocument, elem) && setGlobalEval(getAll(elem
, "script")), elem.parentNode.removeChild(elem));
            return this;
        },
        empty: function() {
            var elem, i = 0;
            for (; (elem = this[i]) != null; i++) {
                elem.nodeType === 1 && jQuery.cleanData(getAll(elem, !1));
                while (elem.firstChild) elem.removeChild(elem.firstChild);
                elem.options && jQuery.nodeName(elem, "select") && (elem.options.length = 0);
            }
            return this;
        },
        clone: function(dataAndEvents, deepDataAndEvents) {
            return dataAndEvents = dataAndEvents == null ? !1 : dataAndEvents, deepDataAndEvents = deepDataAndEvents == null ? dataAndEvents : deepDataAndEvents, this.map(function() {
                return jQuery.clone(this, dataAndEvents, deepDataAndEvents);
            });
        },
        html: function(value) {
            return access(this, function(value) {
                var elem = this[0] || {}, i = 0, l = this.length;
                
if (value === undefined) return elem.nodeType === 1 ? elem.innerHTML.replace(rinlinejQuery, "") : undefined;
                if (typeof value == "string" && !rnoInnerhtml.test(value) && (support.htmlSerialize || !rnoshimcache.test(value)) && (support.leadingWhitespace || !rleadingWhitespace.test(value)) && !wrapMap[(rtagName.exec(value) || [ "", "" ])[1].toLowerCase()]) {
                    value = value.replace(rxhtmlTag, "<$1></$2>");
                    try {
                        for (; i < l; i++) elem = this[i] || {}, elem.nodeType === 1 && (jQuery.cleanData(getAll(elem, !1)), elem.innerHTML = value);
                        elem = 0;
                    } catch (e) {}
                }
                elem && this.empty().append(value);
            }, null, value, arguments.length);
        },
        replaceWith: function() {
            var arg = arguments[0];
            return this.domManip(arguments, function(elem) {
                arg = this.parentNode, jQuery.cleanData
(getAll(this)), arg && arg.replaceChild(elem, this);
            }), arg && (arg.length || arg.nodeType) ? this : this.remove();
        },
        detach: function(selector) {
            return this.remove(selector, !0);
        },
        domManip: function(args, callback) {
            args = concat.apply([], args);
            var first, node, hasScripts, scripts, doc, fragment, i = 0, l = this.length, set = this, iNoClone = l - 1, value = args[0], isFunction = jQuery.isFunction(value);
            if (isFunction || l > 1 && typeof value == "string" && !support.checkClone && rchecked.test(value)) return this.each(function(index) {
                var self = set.eq(index);
                isFunction && (args[0] = value.call(this, index, self.html())), self.domManip(args, callback);
            });
            if (l) {
                fragment = jQuery.buildFragment(args, this[0].ownerDocument, !1, this), first = fragment.firstChild, fragment.childNodes.length === 1 && (fragment = first
);
                if (first) {
                    scripts = jQuery.map(getAll(fragment, "script"), disableScript), hasScripts = scripts.length;
                    for (; i < l; i++) node = fragment, i !== iNoClone && (node = jQuery.clone(node, !0, !0), hasScripts && jQuery.merge(scripts, getAll(node, "script"))), callback.call(this[i], node, i);
                    if (hasScripts) {
                        doc = scripts[scripts.length - 1].ownerDocument, jQuery.map(scripts, restoreScript);
                        for (i = 0; i < hasScripts; i++) node = scripts[i], rscriptType.test(node.type || "") && !jQuery._data(node, "globalEval") && jQuery.contains(doc, node) && (node.src ? jQuery._evalUrl && jQuery._evalUrl(node.src) : jQuery.globalEval((node.text || node.textContent || node.innerHTML || "").replace(rcleanScript, "")));
                    }
                    fragment = first = null;
                }
            }
            return this;
        }
    }), jQuery.each({
        
appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function(name, original) {
        jQuery.fn[name] = function(selector) {
            var elems, i = 0, ret = [], insert = jQuery(selector), last = insert.length - 1;
            for (; i <= last; i++) elems = i === last ? this : this.clone(!0), jQuery(insert[i])[original](elems), push.apply(ret, elems.get());
            return this.pushStack(ret);
        };
    });
    var iframe, elemdisplay = {};
    function actualDisplay(name, doc) {
        var style, elem = jQuery(doc.createElement(name)).appendTo(doc.body), display = window.getDefaultComputedStyle && (style = window.getDefaultComputedStyle(elem[0])) ? style.display : jQuery.css(elem[0], "display");
        return elem.detach(), display;
    }
    function defaultDisplay(nodeName) {
        var doc = document, display = elemdisplay[nodeName];
        if (!display) {
            
display = actualDisplay(nodeName, doc);
            if (display === "none" || !display) iframe = (iframe || jQuery("<iframe frameborder='0' width='0' height='0'/>")).appendTo(doc.documentElement), doc = (iframe[0].contentWindow || iframe[0].contentDocument).document, doc.write(), doc.close(), display = actualDisplay(nodeName, doc), iframe.detach();
            elemdisplay[nodeName] = display;
        }
        return display;
    }
    (function() {
        var shrinkWrapBlocksVal;
        support.shrinkWrapBlocks = function() {
            if (shrinkWrapBlocksVal != null) return shrinkWrapBlocksVal;
            shrinkWrapBlocksVal = !1;
            var div, body, container;
            body = document.getElementsByTagName("body")[0];
            if (!body || !body.style) return;
            return div = document.createElement("div"), container = document.createElement("div"), container.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", body.appendChild(container
).appendChild(div), typeof div.style.zoom !== strundefined && (div.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:1px;width:1px;zoom:1", div.appendChild(document.createElement("div")).style.width = "5px", shrinkWrapBlocksVal = div.offsetWidth !== 3), body.removeChild(container), shrinkWrapBlocksVal;
        };
    })();
    var rmargin = /^margin/, rnumnonpx = new RegExp("^(" + pnum + ")(?!px)[a-z%]+$", "i"), getStyles, curCSS, rposition = /^(top|right|bottom|left)$/;
    window.getComputedStyle ? (getStyles = function(elem) {
        return elem.ownerDocument.defaultView.getComputedStyle(elem, null);
    }, curCSS = function(elem, name, computed) {
        var width, minWidth, maxWidth, ret, style = elem.style;
        return computed = computed || getStyles(elem), ret = computed ? computed.getPropertyValue(name) || computed[name] : undefined, computed && (ret === "" && !jQuery.contains(elem.ownerDocument
, elem) && (ret = jQuery.style(elem, name)), rnumnonpx.test(ret) && rmargin.test(name) && (width = style.width, minWidth = style.minWidth, maxWidth = style.maxWidth, style.minWidth = style.maxWidth = style.width = ret, ret = computed.width, style.width = width, style.minWidth = minWidth, style.maxWidth = maxWidth)), ret === undefined ? ret : ret + "";
    }) : document.documentElement.currentStyle && (getStyles = function(elem) {
        return elem.currentStyle;
    }, curCSS = function(elem, name, computed) {
        var left, rs, rsLeft, ret, style = elem.style;
        return computed = computed || getStyles(elem), ret = computed ? computed[name] : undefined, ret == null && style && style[name] && (ret = style[name]), rnumnonpx.test(ret) && !rposition.test(name) && (left = style.left, rs = elem.runtimeStyle, rsLeft = rs && rs.left, rsLeft && (rs.left = elem.currentStyle.left), style.left = name === "fontSize" ? "1em" : ret, ret = style.pixelLeft + "px", style.left = left, rsLeft && 
(rs.left = rsLeft)), ret === undefined ? ret : ret + "" || "auto";
    });
    function addGetHookIf(conditionFn, hookFn) {
        return {
            get: function() {
                var condition = conditionFn();
                if (condition == null) return;
                if (condition) {
                    delete this.get;
                    return;
                }
                return (this.get = hookFn).apply(this, arguments);
            }
        };
    }
    (function() {
        var div, style, a, pixelPositionVal, boxSizingReliableVal, reliableHiddenOffsetsVal, reliableMarginRightVal;
        div = document.createElement("div"), div.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", a = div.getElementsByTagName("a")[0], style = a && a.style;
        if (!style) return;
        style.cssText = "float:left;opacity:.5", support.opacity = style.opacity === "0.5", support.cssFloat = !!style.cssFloat, div.style.backgroundClip = "content-box"
, div.cloneNode(!0).style.backgroundClip = "", support.clearCloneStyle = div.style.backgroundClip === "content-box", support.boxSizing = style.boxSizing === "" || style.MozBoxSizing === "" || style.WebkitBoxSizing === "", jQuery.extend(support, {
            reliableHiddenOffsets: function() {
                return reliableHiddenOffsetsVal == null && computeStyleTests(), reliableHiddenOffsetsVal;
            },
            boxSizingReliable: function() {
                return boxSizingReliableVal == null && computeStyleTests(), boxSizingReliableVal;
            },
            pixelPosition: function() {
                return pixelPositionVal == null && computeStyleTests(), pixelPositionVal;
            },
            reliableMarginRight: function() {
                return reliableMarginRightVal == null && computeStyleTests(), reliableMarginRightVal;
            }
        });
        function computeStyleTests() {
            var div, body, container, contents;
            body = document
.getElementsByTagName("body")[0];
            if (!body || !body.style) return;
            div = document.createElement("div"), container = document.createElement("div"), container.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", body.appendChild(container).appendChild(div), div.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:block;margin-top:1%;top:1%;border:1px;padding:1px;width:4px;position:absolute", pixelPositionVal = boxSizingReliableVal = !1, reliableMarginRightVal = !0, window.getComputedStyle && (pixelPositionVal = (window.getComputedStyle(div, null) || {}).top !== "1%", boxSizingReliableVal = (window.getComputedStyle(div, null) || {
                width: "4px"
            }).width === "4px", contents = div.appendChild(document.createElement("div")), contents.style.cssText = div.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0"
, contents.style.marginRight = contents.style.width = "0", div.style.width = "1px", reliableMarginRightVal = !parseFloat((window.getComputedStyle(contents, null) || {}).marginRight)), div.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", contents = div.getElementsByTagName("td"), contents[0].style.cssText = "margin:0;border:0;padding:0;display:none", reliableHiddenOffsetsVal = contents[0].offsetHeight === 0, reliableHiddenOffsetsVal && (contents[0].style.display = "", contents[1].style.display = "none", reliableHiddenOffsetsVal = contents[0].offsetHeight === 0), body.removeChild(container);
        }
    })(), jQuery.swap = function(elem, options, callback, args) {
        var ret, name, old = {};
        for (name in options) old[name] = elem.style[name], elem.style[name] = options[name];
        ret = callback.apply(elem, args || []);
        for (name in options) elem.style[name] = old[name];
        return ret;
    };
    var ralpha = /alpha\([^)]*\)/i, ropacity = /opacity\s*=\s*([^)]*)/
, rdisplayswap = /^(none|table(?!-c[ea]).+)/, rnumsplit = new RegExp("^(" + pnum + ")(.*)$", "i"), rrelNum = new RegExp("^([+-])=(" + pnum + ")", "i"), cssShow = {
        position: "absolute",
        visibility: "hidden",
        display: "block"
    }, cssNormalTransform = {
        letterSpacing: "0",
        fontWeight: "400"
    }, cssPrefixes = [ "Webkit", "O", "Moz", "ms" ];
    function vendorPropName(style, name) {
        if (name in style) return name;
        var capName = name.charAt(0).toUpperCase() + name.slice(1), origName = name, i = cssPrefixes.length;
        while (i--) {
            name = cssPrefixes[i] + capName;
            if (name in style) return name;
        }
        return origName;
    }
    function showHide(elements, show) {
        var display, elem, hidden, values = [], index = 0, length = elements.length;
        for (; index < length; index++) {
            elem = elements[index];
            if (!elem.style) continue;
            values[index] = jQuery
._data(elem, "olddisplay"), display = elem.style.display, show ? (!values[index] && display === "none" && (elem.style.display = ""), elem.style.display === "" && isHidden(elem) && (values[index] = jQuery._data(elem, "olddisplay", defaultDisplay(elem.nodeName)))) : (hidden = isHidden(elem), (display && display !== "none" || !hidden) && jQuery._data(elem, "olddisplay", hidden ? display : jQuery.css(elem, "display")));
        }
        for (index = 0; index < length; index++) {
            elem = elements[index];
            if (!elem.style) continue;
            if (!show || elem.style.display === "none" || elem.style.display === "") elem.style.display = show ? values[index] || "" : "none";
        }
        return elements;
    }
    function setPositiveNumber(elem, value, subtract) {
        var matches = rnumsplit.exec(value);
        return matches ? Math.max(0, matches[1] - (subtract || 0)) + (matches[2] || "px") : value;
    }
    function augmentWidthOrHeight(elem, name, extra, isBorderBox
, styles) {
        var i = extra === (isBorderBox ? "border" : "content") ? 4 : name === "width" ? 1 : 0, val = 0;
        for (; i < 4; i += 2) extra === "margin" && (val += jQuery.css(elem, extra + cssExpand[i], !0, styles)), isBorderBox ? (extra === "content" && (val -= jQuery.css(elem, "padding" + cssExpand[i], !0, styles)), extra !== "margin" && (val -= jQuery.css(elem, "border" + cssExpand[i] + "Width", !0, styles))) : (val += jQuery.css(elem, "padding" + cssExpand[i], !0, styles), extra !== "padding" && (val += jQuery.css(elem, "border" + cssExpand[i] + "Width", !0, styles)));
        return val;
    }
    function getWidthOrHeight(elem, name, extra) {
        var valueIsBorderBox = !0, val = name === "width" ? elem.offsetWidth : elem.offsetHeight, styles = getStyles(elem), isBorderBox = support.boxSizing && jQuery.css(elem, "boxSizing", !1, styles) === "border-box";
        if (val <= 0 || val == null) {
            val = curCSS(elem, name, styles);
            if (val < 0 || val == 
null) val = elem.style[name];
            if (rnumnonpx.test(val)) return val;
            valueIsBorderBox = isBorderBox && (support.boxSizingReliable() || val === elem.style[name]), val = parseFloat(val) || 0;
        }
        return val + augmentWidthOrHeight(elem, name, extra || (isBorderBox ? "border" : "content"), valueIsBorderBox, styles) + "px";
    }
    jQuery.extend({
        cssHooks: {
            opacity: {
                get: function(elem, computed) {
                    if (computed) {
                        var ret = curCSS(elem, "opacity");
                        return ret === "" ? "1" : ret;
                    }
                }
            }
        },
        cssNumber: {
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            
zoom: !0
        },
        cssProps: {
            "float": support.cssFloat ? "cssFloat" : "styleFloat"
        },
        style: function(elem, name, value, extra) {
            if (!elem || elem.nodeType === 3 || elem.nodeType === 8 || !elem.style) return;
            var ret, type, hooks, origName = jQuery.camelCase(name), style = elem.style;
            name = jQuery.cssProps[origName] || (jQuery.cssProps[origName] = vendorPropName(style, origName)), hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName];
            if (value === undefined) return hooks && "get" in hooks && (ret = hooks.get(elem, !1, extra)) !== undefined ? ret : style[name];
            type = typeof value, type === "string" && (ret = rrelNum.exec(value)) && (value = (ret[1] + 1) * ret[2] + parseFloat(jQuery.css(elem, name)), type = "number");
            if (value == null || value !== value) return;
            type === "number" && !jQuery.cssNumber[origName] && (value += "px"), !support.clearCloneStyle && 
value === "" && name.indexOf("background") === 0 && (style[name] = "inherit");
            if (!hooks || !("set" in hooks) || (value = hooks.set(elem, value, extra)) !== undefined) try {
                style[name] = value;
            } catch (e) {}
        },
        css: function(elem, name, extra, styles) {
            var num, val, hooks, origName = jQuery.camelCase(name);
            return name = jQuery.cssProps[origName] || (jQuery.cssProps[origName] = vendorPropName(elem.style, origName)), hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName], hooks && "get" in hooks && (val = hooks.get(elem, !0, extra)), val === undefined && (val = curCSS(elem, name, styles)), val === "normal" && name in cssNormalTransform && (val = cssNormalTransform[name]), extra === "" || extra ? (num = parseFloat(val), extra === !0 || jQuery.isNumeric(num) ? num || 0 : val) : val;
        }
    }), jQuery.each([ "height", "width" ], function(i, name) {
        jQuery.cssHooks[name] = {
            get
: function(elem, computed, extra) {
                if (computed) return rdisplayswap.test(jQuery.css(elem, "display")) && elem.offsetWidth === 0 ? jQuery.swap(elem, cssShow, function() {
                    return getWidthOrHeight(elem, name, extra);
                }) : getWidthOrHeight(elem, name, extra);
            },
            set: function(elem, value, extra) {
                var styles = extra && getStyles(elem);
                return setPositiveNumber(elem, value, extra ? augmentWidthOrHeight(elem, name, extra, support.boxSizing && jQuery.css(elem, "boxSizing", !1, styles) === "border-box", styles) : 0);
            }
        };
    }), support.opacity || (jQuery.cssHooks.opacity = {
        get: function(elem, computed) {
            return ropacity.test((computed && elem.currentStyle ? elem.currentStyle.filter : elem.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : computed ? "1" : "";
        },
        set: function(elem, value) {
            var style = elem.style
, currentStyle = elem.currentStyle, opacity = jQuery.isNumeric(value) ? "alpha(opacity=" + value * 100 + ")" : "", filter = currentStyle && currentStyle.filter || style.filter || "";
            style.zoom = 1;
            if ((value >= 1 || value === "") && jQuery.trim(filter.replace(ralpha, "")) === "" && style.removeAttribute) {
                style.removeAttribute("filter");
                if (value === "" || currentStyle && !currentStyle.filter) return;
            }
            style.filter = ralpha.test(filter) ? filter.replace(ralpha, opacity) : filter + " " + opacity;
        }
    }), jQuery.cssHooks.marginRight = addGetHookIf(support.reliableMarginRight, function(elem, computed) {
        if (computed) return jQuery.swap(elem, {
            display: "inline-block"
        }, curCSS, [ elem, "marginRight" ]);
    }), jQuery.each({
        margin: "",
        padding: "",
        border: "Width"
    }, function(prefix, suffix) {
        jQuery.cssHooks[prefix + suffix] = {
            
expand: function(value) {
                var i = 0, expanded = {}, parts = typeof value == "string" ? value.split(" ") : [ value ];
                for (; i < 4; i++) expanded[prefix + cssExpand[i] + suffix] = parts[i] || parts[i - 2] || parts[0];
                return expanded;
            }
        }, rmargin.test(prefix) || (jQuery.cssHooks[prefix + suffix].set = setPositiveNumber);
    }), jQuery.fn.extend({
        css: function(name, value) {
            return access(this, function(elem, name, value) {
                var styles, len, map = {}, i = 0;
                if (jQuery.isArray(name)) {
                    styles = getStyles(elem), len = name.length;
                    for (; i < len; i++) map[name[i]] = jQuery.css(elem, name[i], !1, styles);
                    return map;
                }
                return value !== undefined ? jQuery.style(elem, name, value) : jQuery.css(elem, name);
            }, name, value, arguments.length > 1);
        },
        show: function(
) {
            return showHide(this, !0);
        },
        hide: function() {
            return showHide(this);
        },
        toggle: function(state) {
            return typeof state == "boolean" ? state ? this.show() : this.hide() : this.each(function() {
                isHidden(this) ? jQuery(this).show() : jQuery(this).hide();
            });
        }
    });
    function Tween(elem, options, prop, end, easing) {
        return new Tween.prototype.init(elem, options, prop, end, easing);
    }
    jQuery.Tween = Tween, Tween.prototype = {
        constructor: Tween,
        init: function(elem, options, prop, end, easing, unit) {
            this.elem = elem, this.prop = prop, this.easing = easing || "swing", this.options = options, this.start = this.now = this.cur(), this.end = end, this.unit = unit || (jQuery.cssNumber[prop] ? "" : "px");
        },
        cur: function() {
            var hooks = Tween.propHooks[this.prop];
            return hooks && hooks.get ? hooks
.get(this) : Tween.propHooks._default.get(this);
        },
        run: function(percent) {
            var eased, hooks = Tween.propHooks[this.prop];
            return this.options.duration ? this.pos = eased = jQuery.easing[this.easing](percent, this.options.duration * percent, 0, 1, this.options.duration) : this.pos = eased = percent, this.now = (this.end - this.start) * eased + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), hooks && hooks.set ? hooks.set(this) : Tween.propHooks._default.set(this), this;
        }
    }, Tween.prototype.init.prototype = Tween.prototype, Tween.propHooks = {
        _default: {
            get: function(tween) {
                var result;
                return tween.elem[tween.prop] == null || !!tween.elem.style && tween.elem.style[tween.prop] != null ? (result = jQuery.css(tween.elem, tween.prop, ""), !result || result === "auto" ? 0 : result) : tween.elem[tween.prop];
            },
            set: function(tween
) {
                jQuery.fx.step[tween.prop] ? jQuery.fx.step[tween.prop](tween) : tween.elem.style && (tween.elem.style[jQuery.cssProps[tween.prop]] != null || jQuery.cssHooks[tween.prop]) ? jQuery.style(tween.elem, tween.prop, tween.now + tween.unit) : tween.elem[tween.prop] = tween.now;
            }
        }
    }, Tween.propHooks.scrollTop = Tween.propHooks.scrollLeft = {
        set: function(tween) {
            tween.elem.nodeType && tween.elem.parentNode && (tween.elem[tween.prop] = tween.now);
        }
    }, jQuery.easing = {
        linear: function(p) {
            return p;
        },
        swing: function(p) {
            return .5 - Math.cos(p * Math.PI) / 2;
        }
    }, jQuery.fx = Tween.prototype.init, jQuery.fx.step = {};
    var fxNow, timerId, rfxtypes = /^(?:toggle|show|hide)$/, rfxnum = new RegExp("^(?:([+-])=|)(" + pnum + ")([a-z%]*)$", "i"), rrun = /queueHooks$/, animationPrefilters = [ defaultPrefilter ], tweeners = {
        "*": [ function(prop, value
) {
            var tween = this.createTween(prop, value), target = tween.cur(), parts = rfxnum.exec(value), unit = parts && parts[3] || (jQuery.cssNumber[prop] ? "" : "px"), start = (jQuery.cssNumber[prop] || unit !== "px" && +target) && rfxnum.exec(jQuery.css(tween.elem, prop)), scale = 1, maxIterations = 20;
            if (start && start[3] !== unit) {
                unit = unit || start[3], parts = parts || [], start = +target || 1;
                do scale = scale || ".5", start /= scale, jQuery.style(tween.elem, prop, start + unit); while (scale !== (scale = tween.cur() / target) && scale !== 1 && --maxIterations);
            }
            return parts && (start = tween.start = +start || +target || 0, tween.unit = unit, tween.end = parts[1] ? start + (parts[1] + 1) * parts[2] : +parts[2]), tween;
        } ]
    };
    function createFxNow() {
        return setTimeout(function() {
            fxNow = undefined;
        }), fxNow = jQuery.now();
    }
    function genFx(type, includeWidth
) {
        var which, attrs = {
            height: type
        }, i = 0;
        includeWidth = includeWidth ? 1 : 0;
        for (; i < 4; i += 2 - includeWidth) which = cssExpand[i], attrs["margin" + which] = attrs["padding" + which] = type;
        return includeWidth && (attrs.opacity = attrs.width = type), attrs;
    }
    function createTween(value, prop, animation) {
        var tween, collection = (tweeners[prop] || []).concat(tweeners["*"]), index = 0, length = collection.length;
        for (; index < length; index++) if (tween = collection[index].call(animation, prop, value)) return tween;
    }
    function defaultPrefilter(elem, props, opts) {
        var prop, value, toggle, tween, hooks, oldfire, display, checkDisplay, anim = this, orig = {}, style = elem.style, hidden = elem.nodeType && isHidden(elem), dataShow = jQuery._data(elem, "fxshow");
        opts.queue || (hooks = jQuery._queueHooks(elem, "fx"), hooks.unqueued == null && (hooks.unqueued = 0, oldfire = hooks.empty
.fire, hooks.empty.fire = function() {
            hooks.unqueued || oldfire();
        }), hooks.unqueued++, anim.always(function() {
            anim.always(function() {
                hooks.unqueued--, jQuery.queue(elem, "fx").length || hooks.empty.fire();
            });
        })), elem.nodeType === 1 && ("height" in props || "width" in props) && (opts.overflow = [ style.overflow, style.overflowX, style.overflowY ], display = jQuery.css(elem, "display"), checkDisplay = display === "none" ? jQuery._data(elem, "olddisplay") || defaultDisplay(elem.nodeName) : display, checkDisplay === "inline" && jQuery.css(elem, "float") === "none" && (!support.inlineBlockNeedsLayout || defaultDisplay(elem.nodeName) === "inline" ? style.display = "inline-block" : style.zoom = 1)), opts.overflow && (style.overflow = "hidden", support.shrinkWrapBlocks() || anim.always(function() {
            style.overflow = opts.overflow[0], style.overflowX = opts.overflow[1], style.overflowY = opts.overflow[2];
        
}));
        for (prop in props) {
            value = props[prop];
            if (rfxtypes.exec(value)) {
                delete props[prop], toggle = toggle || value === "toggle";
                if (value === (hidden ? "hide" : "show")) {
                    if (value !== "show" || !dataShow || dataShow[prop] === undefined) continue;
                    hidden = !0;
                }
                orig[prop] = dataShow && dataShow[prop] || jQuery.style(elem, prop);
            } else display = undefined;
        }
        if (!jQuery.isEmptyObject(orig)) {
            dataShow ? "hidden" in dataShow && (hidden = dataShow.hidden) : dataShow = jQuery._data(elem, "fxshow", {}), toggle && (dataShow.hidden = !hidden), hidden ? jQuery(elem).show() : anim.done(function() {
                jQuery(elem).hide();
            }), anim.done(function() {
                var prop;
                jQuery._removeData(elem, "fxshow");
                for (prop in orig) jQuery.style(elem, prop, orig
[prop]);
            });
            for (prop in orig) tween = createTween(hidden ? dataShow[prop] : 0, prop, anim), prop in dataShow || (dataShow[prop] = tween.start, hidden && (tween.end = tween.start, tween.start = prop === "width" || prop === "height" ? 1 : 0));
        } else (display === "none" ? defaultDisplay(elem.nodeName) : display) === "inline" && (style.display = display);
    }
    function propFilter(props, specialEasing) {
        var index, name, easing, value, hooks;
        for (index in props) {
            name = jQuery.camelCase(index), easing = specialEasing[name], value = props[index], jQuery.isArray(value) && (easing = value[1], value = props[index] = value[0]), index !== name && (props[name] = value, delete props[index]), hooks = jQuery.cssHooks[name];
            if (hooks && "expand" in hooks) {
                value = hooks.expand(value), delete props[name];
                for (index in value) index in props || (props[index] = value[index], specialEasing[index
] = easing);
            } else specialEasing[name] = easing;
        }
    }
    function Animation(elem, properties, options) {
        var result, stopped, index = 0, length = animationPrefilters.length, deferred = jQuery.Deferred().always(function() {
            delete tick.elem;
        }), tick = function() {
            if (stopped) return !1;
            var currentTime = fxNow || createFxNow(), remaining = Math.max(0, animation.startTime + animation.duration - currentTime), temp = remaining / animation.duration || 0, percent = 1 - temp, index = 0, length = animation.tweens.length;
            for (; index < length; index++) animation.tweens[index].run(percent);
            return deferred.notifyWith(elem, [ animation, percent, remaining ]), percent < 1 && length ? remaining : (deferred.resolveWith(elem, [ animation ]), !1);
        }, animation = deferred.promise({
            elem: elem,
            props: jQuery.extend({}, properties),
            opts: jQuery.extend(!0, {
                
specialEasing: {}
            }, options),
            originalProperties: properties,
            originalOptions: options,
            startTime: fxNow || createFxNow(),
            duration: options.duration,
            tweens: [],
            createTween: function(prop, end) {
                var tween = jQuery.Tween(elem, animation.opts, prop, end, animation.opts.specialEasing[prop] || animation.opts.easing);
                return animation.tweens.push(tween), tween;
            },
            stop: function(gotoEnd) {
                var index = 0, length = gotoEnd ? animation.tweens.length : 0;
                if (stopped) return this;
                stopped = !0;
                for (; index < length; index++) animation.tweens[index].run(1);
                return gotoEnd ? deferred.resolveWith(elem, [ animation, gotoEnd ]) : deferred.rejectWith(elem, [ animation, gotoEnd ]), this;
            }
        }), props = animation.props;
        propFilter(props, animation.opts.specialEasing
);
        for (; index < length; index++) {
            result = animationPrefilters[index].call(animation, elem, props, animation.opts);
            if (result) return result;
        }
        return jQuery.map(props, createTween, animation), jQuery.isFunction(animation.opts.start) && animation.opts.start.call(elem, animation), jQuery.fx.timer(jQuery.extend(tick, {
            elem: elem,
            anim: animation,
            queue: animation.opts.queue
        })), animation.progress(animation.opts.progress).done(animation.opts.done, animation.opts.complete).fail(animation.opts.fail).always(animation.opts.always);
    }
    jQuery.Animation = jQuery.extend(Animation, {
        tweener: function(props, callback) {
            jQuery.isFunction(props) ? (callback = props, props = [ "*" ]) : props = props.split(" ");
            var prop, index = 0, length = props.length;
            for (; index < length; index++) prop = props[index], tweeners[prop] = tweeners[prop] || [], tweeners
[prop].unshift(callback);
        },
        prefilter: function(callback, prepend) {
            prepend ? animationPrefilters.unshift(callback) : animationPrefilters.push(callback);
        }
    }), jQuery.speed = function(speed, easing, fn) {
        var opt = speed && typeof speed == "object" ? jQuery.extend({}, speed) : {
            complete: fn || !fn && easing || jQuery.isFunction(speed) && speed,
            duration: speed,
            easing: fn && easing || easing && !jQuery.isFunction(easing) && easing
        };
        opt.duration = jQuery.fx.off ? 0 : typeof opt.duration == "number" ? opt.duration : opt.duration in jQuery.fx.speeds ? jQuery.fx.speeds[opt.duration] : jQuery.fx.speeds._default;
        if (opt.queue == null || opt.queue === !0) opt.queue = "fx";
        return opt.old = opt.complete, opt.complete = function() {
            jQuery.isFunction(opt.old) && opt.old.call(this), opt.queue && jQuery.dequeue(this, opt.queue);
        }, opt;
    }, jQuery.fn.extend
({
        fadeTo: function(speed, to, easing, callback) {
            return this.filter(isHidden).css("opacity", 0).show().end().animate({
                opacity: to
            }, speed, easing, callback);
        },
        animate: function(prop, speed, easing, callback) {
            var empty = jQuery.isEmptyObject(prop), optall = jQuery.speed(speed, easing, callback), doAnimation = function() {
                var anim = Animation(this, jQuery.extend({}, prop), optall);
                (empty || jQuery._data(this, "finish")) && anim.stop(!0);
            };
            return doAnimation.finish = doAnimation, empty || optall.queue === !1 ? this.each(doAnimation) : this.queue(optall.queue, doAnimation);
        },
        stop: function(type, clearQueue, gotoEnd) {
            var stopQueue = function(hooks) {
                var stop = hooks.stop;
                delete hooks.stop, stop(gotoEnd);
            };
            return typeof type != "string" && (gotoEnd = clearQueue
, clearQueue = type, type = undefined), clearQueue && type !== !1 && this.queue(type || "fx", []), this.each(function() {
                var dequeue = !0, index = type != null && type + "queueHooks", timers = jQuery.timers, data = jQuery._data(this);
                if (index) data[index] && data[index].stop && stopQueue(data[index]); else for (index in data) data[index] && data[index].stop && rrun.test(index) && stopQueue(data[index]);
                for (index = timers.length; index--; ) timers[index].elem === this && (type == null || timers[index].queue === type) && (timers[index].anim.stop(gotoEnd), dequeue = !1, timers.splice(index, 1));
                (dequeue || !gotoEnd) && jQuery.dequeue(this, type);
            });
        },
        finish: function(type) {
            return type !== !1 && (type = type || "fx"), this.each(function() {
                var index, data = jQuery._data(this), queue = data[type + "queue"], hooks = data[type + "queueHooks"], timers = jQuery.timers
, length = queue ? queue.length : 0;
                data.finish = !0, jQuery.queue(this, type, []), hooks && hooks.stop && hooks.stop.call(this, !0);
                for (index = timers.length; index--; ) timers[index].elem === this && timers[index].queue === type && (timers[index].anim.stop(!0), timers.splice(index, 1));
                for (index = 0; index < length; index++) queue[index] && queue[index].finish && queue[index].finish.call(this);
                delete data.finish;
            });
        }
    }), jQuery.each([ "toggle", "show", "hide" ], function(i, name) {
        var cssFn = jQuery.fn[name];
        jQuery.fn[name] = function(speed, easing, callback) {
            return speed == null || typeof speed == "boolean" ? cssFn.apply(this, arguments) : this.animate(genFx(name, !0), speed, easing, callback);
        };
    }), jQuery.each({
        slideDown: genFx("show"),
        slideUp: genFx("hide"),
        slideToggle: genFx("toggle"),
        fadeIn: {
            
opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        },
        fadeToggle: {
            opacity: "toggle"
        }
    }, function(name, props) {
        jQuery.fn[name] = function(speed, easing, callback) {
            return this.animate(props, speed, easing, callback);
        };
    }), jQuery.timers = [], jQuery.fx.tick = function() {
        var timer, timers = jQuery.timers, i = 0;
        fxNow = jQuery.now();
        for (; i < timers.length; i++) timer = timers[i], !timer() && timers[i] === timer && timers.splice(i--, 1);
        timers.length || jQuery.fx.stop(), fxNow = undefined;
    }, jQuery.fx.timer = function(timer) {
        jQuery.timers.push(timer), timer() ? jQuery.fx.start() : jQuery.timers.pop();
    }, jQuery.fx.interval = 13, jQuery.fx.start = function() {
        timerId || (timerId = setInterval(jQuery.fx.tick, jQuery.fx.interval));
    }, jQuery.fx.stop = function() {
        clearInterval(timerId), timerId = null;
    }, jQuery
.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    }, jQuery.fn.delay = function(time, type) {
        return time = jQuery.fx ? jQuery.fx.speeds[time] || time : time, type = type || "fx", this.queue(type, function(next, hooks) {
            var timeout = setTimeout(next, time);
            hooks.stop = function() {
                clearTimeout(timeout);
            };
        });
    }, function() {
        var input, div, select, a, opt;
        div = document.createElement("div"), div.setAttribute("className", "t"), div.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", a = div.getElementsByTagName("a")[0], select = document.createElement("select"), opt = select.appendChild(document.createElement("option")), input = div.getElementsByTagName("input")[0], a.style.cssText = "top:1px", support.getSetAttribute = div.className !== "t", support.style = /top/.test(a.getAttribute("style")), support.hrefNormalized = a.getAttribute("href"
) === "/a", support.checkOn = !!input.value, support.optSelected = opt.selected, support.enctype = !!document.createElement("form").enctype, select.disabled = !0, support.optDisabled = !opt.disabled, input = document.createElement("input"), input.setAttribute("value", ""), support.input = input.getAttribute("value") === "", input.value = "t", input.setAttribute("type", "radio"), support.radioValue = input.value === "t";
    }();
    var rreturn = /\r/g;
    jQuery.fn.extend({
        val: function(value) {
            var hooks, ret, isFunction, elem = this[0];
            if (!arguments.length) {
                if (elem) return hooks = jQuery.valHooks[elem.type] || jQuery.valHooks[elem.nodeName.toLowerCase()], hooks && "get" in hooks && (ret = hooks.get(elem, "value")) !== undefined ? ret : (ret = elem.value, typeof ret == "string" ? ret.replace(rreturn, "") : ret == null ? "" : ret);
                return;
            }
            return isFunction = jQuery.isFunction(value), this.
each(function(i) {
                var val;
                if (this.nodeType !== 1) return;
                isFunction ? val = value.call(this, i, jQuery(this).val()) : val = value, val == null ? val = "" : typeof val == "number" ? val += "" : jQuery.isArray(val) && (val = jQuery.map(val, function(value) {
                    return value == null ? "" : value + "";
                })), hooks = jQuery.valHooks[this.type] || jQuery.valHooks[this.nodeName.toLowerCase()];
                if (!hooks || !("set" in hooks) || hooks.set(this, val, "value") === undefined) this.value = val;
            });
        }
    }), jQuery.extend({
        valHooks: {
            option: {
                get: function(elem) {
                    var val = jQuery.find.attr(elem, "value");
                    return val != null ? val : jQuery.trim(jQuery.text(elem));
                }
            },
            select: {
                get: function(elem) {
                    var value, option, options = 
elem.options, index = elem.selectedIndex, one = elem.type === "select-one" || index < 0, values = one ? null : [], max = one ? index + 1 : options.length, i = index < 0 ? max : one ? index : 0;
                    for (; i < max; i++) {
                        option = options[i];
                        if ((option.selected || i === index) && (support.optDisabled ? !option.disabled : option.getAttribute("disabled") === null) && (!option.parentNode.disabled || !jQuery.nodeName(option.parentNode, "optgroup"))) {
                            value = jQuery(option).val();
                            if (one) return value;
                            values.push(value);
                        }
                    }
                    return values;
                },
                set: function(elem, value) {
                    var optionSet, option, options = elem.options, values = jQuery.makeArray(value), i = options.length;
                    while (i--) {
                        option = 
options[i];
                        if (jQuery.inArray(jQuery.valHooks.option.get(option), values) >= 0) try {
                            option.selected = optionSet = !0;
                        } catch (_) {
                            option.scrollHeight;
                        } else option.selected = !1;
                    }
                    return optionSet || (elem.selectedIndex = -1), options;
                }
            }
        }
    }), jQuery.each([ "radio", "checkbox" ], function() {
        jQuery.valHooks[this] = {
            set: function(elem, value) {
                if (jQuery.isArray(value)) return elem.checked = jQuery.inArray(jQuery(elem).val(), value) >= 0;
            }
        }, support.checkOn || (jQuery.valHooks[this].get = function(elem) {
            return elem.getAttribute("value") === null ? "on" : elem.value;
        });
    });
    var nodeHook, boolHook, attrHandle = jQuery.expr.attrHandle, ruseDefault = /^(?:checked|selected)$/i, getSetAttribute = 
support.getSetAttribute, getSetInput = support.input;
    jQuery.fn.extend({
        attr: function(name, value) {
            return access(this, jQuery.attr, name, value, arguments.length > 1);
        },
        removeAttr: function(name) {
            return this.each(function() {
                jQuery.removeAttr(this, name);
            });
        }
    }), jQuery.extend({
        attr: function(elem, name, value) {
            var hooks, ret, nType = elem.nodeType;
            if (!elem || nType === 3 || nType === 8 || nType === 2) return;
            if (typeof elem.getAttribute === strundefined) return jQuery.prop(elem, name, value);
            if (nType !== 1 || !jQuery.isXMLDoc(elem)) name = name.toLowerCase(), hooks = jQuery.attrHooks[name] || (jQuery.expr.match.bool.test(name) ? boolHook : nodeHook);
            if (value === undefined) return hooks && "get" in hooks && (ret = hooks.get(elem, name)) !== null ? ret : (ret = jQuery.find.attr(elem, name), ret == null ? undefined 
: ret);
            if (value !== null) return hooks && "set" in hooks && (ret = hooks.set(elem, value, name)) !== undefined ? ret : (elem.setAttribute(name, value + ""), value);
            jQuery.removeAttr(elem, name);
        },
        removeAttr: function(elem, value) {
            var name, propName, i = 0, attrNames = value && value.match(rnotwhite);
            if (attrNames && elem.nodeType === 1) while (name = attrNames[i++]) propName = jQuery.propFix[name] || name, jQuery.expr.match.bool.test(name) ? getSetInput && getSetAttribute || !ruseDefault.test(name) ? elem[propName] = !1 : elem[jQuery.camelCase("default-" + name)] = elem[propName] = !1 : jQuery.attr(elem, name, ""), elem.removeAttribute(getSetAttribute ? name : propName);
        },
        attrHooks: {
            type: {
                set: function(elem, value) {
                    if (!support.radioValue && value === "radio" && jQuery.nodeName(elem, "input")) {
                        var val = elem.value;
                        
return elem.setAttribute("type", value), val && (elem.value = val), value;
                    }
                }
            }
        }
    }), boolHook = {
        set: function(elem, value, name) {
            return value === !1 ? jQuery.removeAttr(elem, name) : getSetInput && getSetAttribute || !ruseDefault.test(name) ? elem.setAttribute(!getSetAttribute && jQuery.propFix[name] || name, name) : elem[jQuery.camelCase("default-" + name)] = elem[name] = !0, name;
        }
    }, jQuery.each(jQuery.expr.match.bool.source.match(/\w+/g), function(i, name) {
        var getter = attrHandle[name] || jQuery.find.attr;
        attrHandle[name] = getSetInput && getSetAttribute || !ruseDefault.test(name) ? function(elem, name, isXML) {
            var ret, handle;
            return isXML || (handle = attrHandle[name], attrHandle[name] = ret, ret = getter(elem, name, isXML) != null ? name.toLowerCase() : null, attrHandle[name] = handle), ret;
        } : function(elem, name, isXML) {
            
if (!isXML) return elem[jQuery.camelCase("default-" + name)] ? name.toLowerCase() : null;
        };
    });
    if (!getSetInput || !getSetAttribute) jQuery.attrHooks.value = {
        set: function(elem, value, name) {
            if (!jQuery.nodeName(elem, "input")) return nodeHook && nodeHook.set(elem, value, name);
            elem.defaultValue = value;
        }
    };
    getSetAttribute || (nodeHook = {
        set: function(elem, value, name) {
            var ret = elem.getAttributeNode(name);
            ret || elem.setAttributeNode(ret = elem.ownerDocument.createAttribute(name)), ret.value = value += "";
            if (name === "value" || value === elem.getAttribute(name)) return value;
        }
    }, attrHandle.id = attrHandle.name = attrHandle.coords = function(elem, name, isXML) {
        var ret;
        if (!isXML) return (ret = elem.getAttributeNode(name)) && ret.value !== "" ? ret.value : null;
    }, jQuery.valHooks.button = {
        get: function(elem, name) {
            
var ret = elem.getAttributeNode(name);
            if (ret && ret.specified) return ret.value;
        },
        set: nodeHook.set
    }, jQuery.attrHooks.contenteditable = {
        set: function(elem, value, name) {
            nodeHook.set(elem, value === "" ? !1 : value, name);
        }
    }, jQuery.each([ "width", "height" ], function(i, name) {
        jQuery.attrHooks[name] = {
            set: function(elem, value) {
                if (value === "") return elem.setAttribute(name, "auto"), value;
            }
        };
    })), support.style || (jQuery.attrHooks.style = {
        get: function(elem) {
            return elem.style.cssText || undefined;
        },
        set: function(elem, value) {
            return elem.style.cssText = value + "";
        }
    });
    var rfocusable = /^(?:input|select|textarea|button|object)$/i, rclickable = /^(?:a|area)$/i;
    jQuery.fn.extend({
        prop: function(name, value) {
            return access(this, jQuery.prop, name, 
value, arguments.length > 1);
        },
        removeProp: function(name) {
            return name = jQuery.propFix[name] || name, this.each(function() {
                try {
                    this[name] = undefined, delete this[name];
                } catch (e) {}
            });
        }
    }), jQuery.extend({
        propFix: {
            "for": "htmlFor",
            "class": "className"
        },
        prop: function(elem, name, value) {
            var ret, hooks, notxml, nType = elem.nodeType;
            if (!elem || nType === 3 || nType === 8 || nType === 2) return;
            return notxml = nType !== 1 || !jQuery.isXMLDoc(elem), notxml && (name = jQuery.propFix[name] || name, hooks = jQuery.propHooks[name]), value !== undefined ? hooks && "set" in hooks && (ret = hooks.set(elem, value, name)) !== undefined ? ret : elem[name] = value : hooks && "get" in hooks && (ret = hooks.get(elem, name)) !== null ? ret : elem[name];
        },
        propHooks: {
            
tabIndex: {
                get: function(elem) {
                    var tabindex = jQuery.find.attr(elem, "tabindex");
                    return tabindex ? parseInt(tabindex, 10) : rfocusable.test(elem.nodeName) || rclickable.test(elem.nodeName) && elem.href ? 0 : -1;
                }
            }
        }
    }), support.hrefNormalized || jQuery.each([ "href", "src" ], function(i, name) {
        jQuery.propHooks[name] = {
            get: function(elem) {
                return elem.getAttribute(name, 4);
            }
        };
    }), support.optSelected || (jQuery.propHooks.selected = {
        get: function(elem) {
            var parent = elem.parentNode;
            return parent && (parent.selectedIndex, parent.parentNode && parent.parentNode.selectedIndex), null;
        }
    }), jQuery.each([ "tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable" ], function() {
        jQuery.propFix[this.toLowerCase
()] = this;
    }), support.enctype || (jQuery.propFix.enctype = "encoding");
    var rclass = /[\t\r\n\f]/g;
    jQuery.fn.extend({
        addClass: function(value) {
            var classes, elem, cur, clazz, j, finalValue, i = 0, len = this.length, proceed = typeof value == "string" && value;
            if (jQuery.isFunction(value)) return this.each(function(j) {
                jQuery(this).addClass(value.call(this, j, this.className));
            });
            if (proceed) {
                classes = (value || "").match(rnotwhite) || [];
                for (; i < len; i++) {
                    elem = this[i], cur = elem.nodeType === 1 && (elem.className ? (" " + elem.className + " ").replace(rclass, " ") : " ");
                    if (cur) {
                        j = 0;
                        while (clazz = classes[j++]) cur.indexOf(" " + clazz + " ") < 0 && (cur += clazz + " ");
                        finalValue = jQuery.trim(cur), elem.className !== finalValue && (elem
.className = finalValue);
                    }
                }
            }
            return this;
        },
        removeClass: function(value) {
            var classes, elem, cur, clazz, j, finalValue, i = 0, len = this.length, proceed = arguments.length === 0 || typeof value == "string" && value;
            if (jQuery.isFunction(value)) return this.each(function(j) {
                jQuery(this).removeClass(value.call(this, j, this.className));
            });
            if (proceed) {
                classes = (value || "").match(rnotwhite) || [];
                for (; i < len; i++) {
                    elem = this[i], cur = elem.nodeType === 1 && (elem.className ? (" " + elem.className + " ").replace(rclass, " ") : "");
                    if (cur) {
                        j = 0;
                        while (clazz = classes[j++]) while (cur.indexOf(" " + clazz + " ") >= 0) cur = cur.replace(" " + clazz + " ", " ");
                        finalValue = value ? jQuery
.trim(cur) : "", elem.className !== finalValue && (elem.className = finalValue);
                    }
                }
            }
            return this;
        },
        toggleClass: function(value, stateVal) {
            var type = typeof value;
            return typeof stateVal == "boolean" && type === "string" ? stateVal ? this.addClass(value) : this.removeClass(value) : jQuery.isFunction(value) ? this.each(function(i) {
                jQuery(this).toggleClass(value.call(this, i, this.className, stateVal), stateVal);
            }) : this.each(function() {
                if (type === "string") {
                    var className, i = 0, self = jQuery(this), classNames = value.match(rnotwhite) || [];
                    while (className = classNames[i++]) self.hasClass(className) ? self.removeClass(className) : self.addClass(className);
                } else if (type === strundefined || type === "boolean") this.className && jQuery._data(this, "__className__", this.className
), this.className = this.className || value === !1 ? "" : jQuery._data(this, "__className__") || "";
            });
        },
        hasClass: function(selector) {
            var className = " " + selector + " ", i = 0, l = this.length;
            for (; i < l; i++) if (this[i].nodeType === 1 && (" " + this[i].className + " ").replace(rclass, " ").indexOf(className) >= 0) return !0;
            return !1;
        }
    }), jQuery.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function(i, name) {
        jQuery.fn[name] = function(data, fn) {
            return arguments.length > 0 ? this.on(name, null, data, fn) : this.trigger(name);
        };
    }), jQuery.fn.extend({
        hover: function(fnOver, fnOut) {
            return this.mouseenter(fnOver).mouseleave(fnOut || fnOver);
        },
        bind: function(
types, data, fn) {
            return this.on(types, null, data, fn);
        },
        unbind: function(types, fn) {
            return this.off(types, null, fn);
        },
        delegate: function(selector, types, data, fn) {
            return this.on(types, selector, data, fn);
        },
        undelegate: function(selector, types, fn) {
            return arguments.length === 1 ? this.off(selector, "**") : this.off(types, selector || "**", fn);
        }
    });
    var nonce = jQuery.now(), rquery = /\?/, rvalidtokens = /(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g;
    jQuery.parseJSON = function(data) {
        if (window.JSON && window.JSON.parse) return window.JSON.parse(data + "");
        var requireNonComma, depth = null, str = jQuery.trim(data + "");
        return str && !jQuery.trim(str.replace(rvalidtokens, function(token, comma, open, close) {
            return requireNonComma && 
comma && (depth = 0), depth === 0 ? token : (requireNonComma = open || comma, depth += !close - !open, "");
        })) ? Function("return " + str)() : jQuery.error("Invalid JSON: " + data);
    }, jQuery.parseXML = function(data) {
        var xml, tmp;
        if (!data || typeof data != "string") return null;
        try {
            window.DOMParser ? (tmp = new DOMParser, xml = tmp.parseFromString(data, "text/xml")) : (xml = new ActiveXObject("Microsoft.XMLDOM"), xml.async = "false", xml.loadXML(data));
        } catch (e) {
            xml = undefined;
        }
        return (!xml || !xml.documentElement || xml.getElementsByTagName("parsererror").length) && jQuery.error("Invalid XML: " + data), xml;
    };
    var ajaxLocParts, ajaxLocation, rhash = /#.*$/, rts = /([?&])_=[^&]*/, rheaders = /^(.*?):[ \t]*([^\r\n]*)\r?$/mg, rlocalProtocol = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/, rnoContent = /^(?:GET|HEAD)$/, rprotocol = /^\/\//, rurl = /^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/
, prefilters = {}, transports = {}, allTypes = "*/".concat("*");
    try {
        ajaxLocation = location.href;
    } catch (e) {
        ajaxLocation = document.createElement("a"), ajaxLocation.href = "", ajaxLocation = ajaxLocation.href;
    }
    ajaxLocParts = rurl.exec(ajaxLocation.toLowerCase()) || [];
    function addToPrefiltersOrTransports(structure) {
        return function(dataTypeExpression, func) {
            typeof dataTypeExpression != "string" && (func = dataTypeExpression, dataTypeExpression = "*");
            var dataType, i = 0, dataTypes = dataTypeExpression.toLowerCase().match(rnotwhite) || [];
            if (jQuery.isFunction(func)) while (dataType = dataTypes[i++]) dataType.charAt(0) === "+" ? (dataType = dataType.slice(1) || "*", (structure[dataType] = structure[dataType] || []).unshift(func)) : (structure[dataType] = structure[dataType] || []).push(func);
        };
    }
    function inspectPrefiltersOrTransports(structure, options, originalOptions, jqXHR) 
{
        var inspected = {}, seekingTransport = structure === transports;
        function inspect(dataType) {
            var selected;
            return inspected[dataType] = !0, jQuery.each(structure[dataType] || [], function(_, prefilterOrFactory) {
                var dataTypeOrTransport = prefilterOrFactory(options, originalOptions, jqXHR);
                if (typeof dataTypeOrTransport == "string" && !seekingTransport && !inspected[dataTypeOrTransport]) return options.dataTypes.unshift(dataTypeOrTransport), inspect(dataTypeOrTransport), !1;
                if (seekingTransport) return !(selected = dataTypeOrTransport);
            }), selected;
        }
        return inspect(options.dataTypes[0]) || !inspected["*"] && inspect("*");
    }
    function ajaxExtend(target, src) {
        var deep, key, flatOptions = jQuery.ajaxSettings.flatOptions || {};
        for (key in src) src[key] !== undefined && ((flatOptions[key] ? target : deep || (deep = {}))[key] = src[key]);
        
return deep && jQuery.extend(!0, target, deep), target;
    }
    function ajaxHandleResponses(s, jqXHR, responses) {
        var firstDataType, ct, finalDataType, type, contents = s.contents, dataTypes = s.dataTypes;
        while (dataTypes[0] === "*") dataTypes.shift(), ct === undefined && (ct = s.mimeType || jqXHR.getResponseHeader("Content-Type"));
        if (ct) for (type in contents) if (contents[type] && contents[type].test(ct)) {
            dataTypes.unshift(type);
            break;
        }
        if (dataTypes[0] in responses) finalDataType = dataTypes[0]; else {
            for (type in responses) {
                if (!dataTypes[0] || s.converters[type + " " + dataTypes[0]]) {
                    finalDataType = type;
                    break;
                }
                firstDataType || (firstDataType = type);
            }
            finalDataType = finalDataType || firstDataType;
        }
        if (finalDataType) return finalDataType !== dataTypes[0] && dataTypes
.unshift(finalDataType), responses[finalDataType];
    }
    function ajaxConvert(s, response, jqXHR, isSuccess) {
        var conv2, current, conv, tmp, prev, converters = {}, dataTypes = s.dataTypes.slice();
        if (dataTypes[1]) for (conv in s.converters) converters[conv.toLowerCase()] = s.converters[conv];
        current = dataTypes.shift();
        while (current) {
            s.responseFields[current] && (jqXHR[s.responseFields[current]] = response), !prev && isSuccess && s.dataFilter && (response = s.dataFilter(response, s.dataType)), prev = current, current = dataTypes.shift();
            if (current) if (current === "*") current = prev; else if (prev !== "*" && prev !== current) {
                conv = converters[prev + " " + current] || converters["* " + current];
                if (!conv) for (conv2 in converters) {
                    tmp = conv2.split(" ");
                    if (tmp[1] === current) {
                        conv = converters[prev + " " + tmp[0]] || 
converters["* " + tmp[0]];
                        if (conv) {
                            conv === !0 ? conv = converters[conv2] : converters[conv2] !== !0 && (current = tmp[0], dataTypes.unshift(tmp[1]));
                            break;
                        }
                    }
                }
                if (conv !== !0) if (conv && s["throws"]) response = conv(response); else try {
                    response = conv(response);
                } catch (e) {
                    return {
                        state: "parsererror",
                        error: conv ? e : "No conversion from " + prev + " to " + current
                    };
                }
            }
        }
        return {
            state: "success",
            data: response
        };
    }
    jQuery.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: ajaxLocation,
            type: "GET",
            isLocal: rlocalProtocol.
test(ajaxLocParts[1]),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": allTypes,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /xml/,
                html: /html/,
                json: /json/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": jQuery.parseJSON,
                "text xml": jQuery.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        
},
        ajaxSetup: function(target, settings) {
            return settings ? ajaxExtend(ajaxExtend(target, jQuery.ajaxSettings), settings) : ajaxExtend(jQuery.ajaxSettings, target);
        },
        ajaxPrefilter: addToPrefiltersOrTransports(prefilters),
        ajaxTransport: addToPrefiltersOrTransports(transports),
        ajax: function(url, options) {
            typeof url == "object" && (options = url, url = undefined), options = options || {};
            var parts, i, cacheURL, responseHeadersString, timeoutTimer, fireGlobals, transport, responseHeaders, s = jQuery.ajaxSetup({}, options), callbackContext = s.context || s, globalEventContext = s.context && (callbackContext.nodeType || callbackContext.jquery) ? jQuery(callbackContext) : jQuery.event, deferred = jQuery.Deferred(), completeDeferred = jQuery.Callbacks("once memory"), statusCode = s.statusCode || {}, requestHeaders = {}, requestHeadersNames = {}, state = 0, strAbort = "canceled", jqXHR = {
                readyState
: 0,
                getResponseHeader: function(key) {
                    var match;
                    if (state === 2) {
                        if (!responseHeaders) {
                            responseHeaders = {};
                            while (match = rheaders.exec(responseHeadersString)) responseHeaders[match[1].toLowerCase()] = match[2];
                        }
                        match = responseHeaders[key.toLowerCase()];
                    }
                    return match == null ? null : match;
                },
                getAllResponseHeaders: function() {
                    return state === 2 ? responseHeadersString : null;
                },
                setRequestHeader: function(name, value) {
                    var lname = name.toLowerCase();
                    return state || (name = requestHeadersNames[lname] = requestHeadersNames[lname] || name, requestHeaders[name] = value), this;
                },
                overrideMimeType: function(
type) {
                    return state || (s.mimeType = type), this;
                },
                statusCode: function(map) {
                    var code;
                    if (map) if (state < 2) for (code in map) statusCode[code] = [ statusCode[code], map[code] ]; else jqXHR.always(map[jqXHR.status]);
                    return this;
                },
                abort: function(statusText) {
                    var finalText = statusText || strAbort;
                    return transport && transport.abort(finalText), done(0, finalText), this;
                }
            };
            deferred.promise(jqXHR).complete = completeDeferred.add, jqXHR.success = jqXHR.done, jqXHR.error = jqXHR.fail, s.url = ((url || s.url || ajaxLocation) + "").replace(rhash, "").replace(rprotocol, ajaxLocParts[1] + "//"), s.type = options.method || options.type || s.method || s.type, s.dataTypes = jQuery.trim(s.dataType || "*").toLowerCase().match(rnotwhite) || [ "" ], s.crossDomain == null && 
(parts = rurl.exec(s.url.toLowerCase()), s.crossDomain = !(!parts || parts[1] === ajaxLocParts[1] && parts[2] === ajaxLocParts[2] && (parts[3] || (parts[1] === "http:" ? "80" : "443")) === (ajaxLocParts[3] || (ajaxLocParts[1] === "http:" ? "80" : "443")))), s.data && s.processData && typeof s.data != "string" && (s.data = jQuery.param(s.data, s.traditional)), inspectPrefiltersOrTransports(prefilters, s, options, jqXHR);
            if (state === 2) return jqXHR;
            fireGlobals = s.global, fireGlobals && jQuery.active++ === 0 && jQuery.event.trigger("ajaxStart"), s.type = s.type.toUpperCase(), s.hasContent = !rnoContent.test(s.type), cacheURL = s.url, s.hasContent || (s.data && (cacheURL = s.url += (rquery.test(cacheURL) ? "&" : "?") + s.data, delete s.data), s.cache === !1 && (s.url = rts.test(cacheURL) ? cacheURL.replace(rts, "$1_=" + nonce++) : cacheURL + (rquery.test(cacheURL) ? "&" : "?") + "_=" + nonce++)), s.ifModified && (jQuery.lastModified[cacheURL] && jqXHR.setRequestHeader
("If-Modified-Since", jQuery.lastModified[cacheURL]), jQuery.etag[cacheURL] && jqXHR.setRequestHeader("If-None-Match", jQuery.etag[cacheURL])), (s.data && s.hasContent && s.contentType !== !1 || options.contentType) && jqXHR.setRequestHeader("Content-Type", s.contentType), jqXHR.setRequestHeader("Accept", s.dataTypes[0] && s.accepts[s.dataTypes[0]] ? s.accepts[s.dataTypes[0]] + (s.dataTypes[0] !== "*" ? ", " + allTypes + "; q=0.01" : "") : s.accepts["*"]);
            for (i in s.headers) jqXHR.setRequestHeader(i, s.headers[i]);
            if (!s.beforeSend || s.beforeSend.call(callbackContext, jqXHR, s) !== !1 && state !== 2) {
                strAbort = "abort";
                for (i in {
                    success: 1,
                    error: 1,
                    complete: 1
                }) jqXHR[i](s[i]);
                transport = inspectPrefiltersOrTransports(transports, s, options, jqXHR);
                if (!transport) done(-1, "No Transport"); else {
                    
jqXHR.readyState = 1, fireGlobals && globalEventContext.trigger("ajaxSend", [ jqXHR, s ]), s.async && s.timeout > 0 && (timeoutTimer = setTimeout(function() {
                        jqXHR.abort("timeout");
                    }, s.timeout));
                    try {
                        state = 1, transport.send(requestHeaders, done);
                    } catch (e) {
                        if (!(state < 2)) throw e;
                        done(-1, e);
                    }
                }
                function done(status, nativeStatusText, responses, headers) {
                    var isSuccess, success, error, response, modified, statusText = nativeStatusText;
                    if (state === 2) return;
                    state = 2, timeoutTimer && clearTimeout(timeoutTimer), transport = undefined, responseHeadersString = headers || "", jqXHR.readyState = status > 0 ? 4 : 0, isSuccess = status >= 200 && status < 300 || status === 304, responses && (response = ajaxHandleResponses
(s, jqXHR, responses)), response = ajaxConvert(s, response, jqXHR, isSuccess);
                    if (isSuccess) s.ifModified && (modified = jqXHR.getResponseHeader("Last-Modified"), modified && (jQuery.lastModified[cacheURL] = modified), modified = jqXHR.getResponseHeader("etag"), modified && (jQuery.etag[cacheURL] = modified)), status === 204 || s.type === "HEAD" ? statusText = "nocontent" : status === 304 ? statusText = "notmodified" : (statusText = response.state, success = response.data, error = response.error, isSuccess = !error); else {
                        error = statusText;
                        if (status || !statusText) statusText = "error", status < 0 && (status = 0);
                    }
                    jqXHR.status = status, jqXHR.statusText = (nativeStatusText || statusText) + "", isSuccess ? deferred.resolveWith(callbackContext, [ success, statusText, jqXHR ]) : deferred.rejectWith(callbackContext, [ jqXHR, statusText, error ]), jqXHR.statusCode(statusCode), 
statusCode = undefined, fireGlobals && globalEventContext.trigger(isSuccess ? "ajaxSuccess" : "ajaxError", [ jqXHR, s, isSuccess ? success : error ]), completeDeferred.fireWith(callbackContext, [ jqXHR, statusText ]), fireGlobals && (globalEventContext.trigger("ajaxComplete", [ jqXHR, s ]), --jQuery.active || jQuery.event.trigger("ajaxStop"));
                }
                return jqXHR;
            }
            return jqXHR.abort();
        },
        getJSON: function(url, data, callback) {
            return jQuery.get(url, data, callback, "json");
        },
        getScript: function(url, callback) {
            return jQuery.get(url, undefined, callback, "script");
        }
    }), jQuery.each([ "get", "post" ], function(i, method) {
        jQuery[method] = function(url, data, callback, type) {
            return jQuery.isFunction(data) && (type = type || callback, callback = data, data = undefined), jQuery.ajax({
                url: url,
                type: method,
                
dataType: type,
                data: data,
                success: callback
            });
        };
    }), jQuery.each([ "ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend" ], function(i, type) {
        jQuery.fn[type] = function(fn) {
            return this.on(type, fn);
        };
    }), jQuery._evalUrl = function(url) {
        return jQuery.ajax({
            url: url,
            type: "GET",
            dataType: "script",
            async: !1,
            global: !1,
            "throws": !0
        });
    }, jQuery.fn.extend({
        wrapAll: function(html) {
            if (jQuery.isFunction(html)) return this.each(function(i) {
                jQuery(this).wrapAll(html.call(this, i));
            });
            if (this[0]) {
                var wrap = jQuery(html, this[0].ownerDocument).eq(0).clone(!0);
                this[0].parentNode && wrap.insertBefore(this[0]), wrap.map(function() {
                    var elem = this;
                    
while (elem.firstChild && elem.firstChild.nodeType === 1) elem = elem.firstChild;
                    return elem;
                }).append(this);
            }
            return this;
        },
        wrapInner: function(html) {
            return jQuery.isFunction(html) ? this.each(function(i) {
                jQuery(this).wrapInner(html.call(this, i));
            }) : this.each(function() {
                var self = jQuery(this), contents = self.contents();
                contents.length ? contents.wrapAll(html) : self.append(html);
            });
        },
        wrap: function(html) {
            var isFunction = jQuery.isFunction(html);
            return this.each(function(i) {
                jQuery(this).wrapAll(isFunction ? html.call(this, i) : html);
            });
        },
        unwrap: function() {
            return this.parent().each(function() {
                jQuery.nodeName(this, "body") || jQuery(this).replaceWith(this.childNodes);
            }).end(
);
        }
    }), jQuery.expr.filters.hidden = function(elem) {
        return elem.offsetWidth <= 0 && elem.offsetHeight <= 0 || !support.reliableHiddenOffsets() && (elem.style && elem.style.display || jQuery.css(elem, "display")) === "none";
    }, jQuery.expr.filters.visible = function(elem) {
        return !jQuery.expr.filters.hidden(elem);
    };
    var r20 = /%20/g, rbracket = /\[\]$/, rCRLF = /\r?\n/g, rsubmitterTypes = /^(?:submit|button|image|reset|file)$/i, rsubmittable = /^(?:input|select|textarea|keygen)/i;
    function buildParams(prefix, obj, traditional, add) {
        var name;
        if (jQuery.isArray(obj)) jQuery.each(obj, function(i, v) {
            traditional || rbracket.test(prefix) ? add(prefix, v) : buildParams(prefix + "[" + (typeof v == "object" ? i : "") + "]", v, traditional, add);
        }); else if (!traditional && jQuery.type(obj) === "object") for (name in obj) buildParams(prefix + "[" + name + "]", obj[name], traditional, add); else add(prefix, 
obj);
    }
    jQuery.param = function(a, traditional) {
        var prefix, s = [], add = function(key, value) {
            value = jQuery.isFunction(value) ? value() : value == null ? "" : value, s[s.length] = encodeURIComponent(key) + "=" + encodeURIComponent(value);
        };
        traditional === undefined && (traditional = jQuery.ajaxSettings && jQuery.ajaxSettings.traditional);
        if (jQuery.isArray(a) || a.jquery && !jQuery.isPlainObject(a)) jQuery.each(a, function() {
            add(this.name, this.value);
        }); else for (prefix in a) buildParams(prefix, a[prefix], traditional, add);
        return s.join("&").replace(r20, "+");
    }, jQuery.fn.extend({
        serialize: function() {
            return jQuery.param(this.serializeArray());
        },
        serializeArray: function() {
            return this.map(function() {
                var elements = jQuery.prop(this, "elements");
                return elements ? jQuery.makeArray(elements) : this;
            
}).filter(function() {
                var type = this.type;
                return this.name && !jQuery(this).is(":disabled") && rsubmittable.test(this.nodeName) && !rsubmitterTypes.test(type) && (this.checked || !rcheckableType.test(type));
            }).map(function(i, elem) {
                var val = jQuery(this).val();
                return val == null ? null : jQuery.isArray(val) ? jQuery.map(val, function(val) {
                    return {
                        name: elem.name,
                        value: val.replace(rCRLF, "\r\n")
                    };
                }) : {
                    name: elem.name,
                    value: val.replace(rCRLF, "\r\n")
                };
            }).get();
        }
    }), jQuery.ajaxSettings.xhr = window.ActiveXObject !== undefined ? function() {
        return !this.isLocal && /^(get|post|head|put|delete|options)$/i.test(this.type) && createStandardXHR() || createActiveXHR();
    } : createStandardXHR;
    var xhrId = 0
, xhrCallbacks = {}, xhrSupported = jQuery.ajaxSettings.xhr();
    window.ActiveXObject && jQuery(window).on("unload", function() {
        for (var key in xhrCallbacks) xhrCallbacks[key](undefined, !0);
    }), support.cors = !!xhrSupported && "withCredentials" in xhrSupported, xhrSupported = support.ajax = !!xhrSupported, xhrSupported && jQuery.ajaxTransport(function(options) {
        if (!options.crossDomain || support.cors) {
            var callback;
            return {
                send: function(headers, complete) {
                    var i, xhr = options.xhr(), id = ++xhrId;
                    xhr.open(options.type, options.url, options.async, options.username, options.password);
                    if (options.xhrFields) for (i in options.xhrFields) xhr[i] = options.xhrFields[i];
                    options.mimeType && xhr.overrideMimeType && xhr.overrideMimeType(options.mimeType), !options.crossDomain && !headers["X-Requested-With"] && (headers["X-Requested-With"] = "XMLHttpRequest"
);
                    for (i in headers) headers[i] !== undefined && xhr.setRequestHeader(i, headers[i] + "");
                    xhr.send(options.hasContent && options.data || null), callback = function(_, isAbort) {
                        var status, statusText, responses;
                        if (callback && (isAbort || xhr.readyState === 4)) {
                            delete xhrCallbacks[id], callback = undefined, xhr.onreadystatechange = jQuery.noop;
                            if (isAbort) xhr.readyState !== 4 && xhr.abort(); else {
                                responses = {}, status = xhr.status, typeof xhr.responseText == "string" && (responses.text = xhr.responseText);
                                try {
                                    statusText = xhr.statusText;
                                } catch (e) {
                                    statusText = "";
                                }
                                !status && options.isLocal && !options
.crossDomain ? status = responses.text ? 200 : 404 : status === 1223 && (status = 204);
                            }
                        }
                        responses && complete(status, statusText, responses, xhr.getAllResponseHeaders());
                    }, options.async ? xhr.readyState === 4 ? setTimeout(callback) : xhr.onreadystatechange = xhrCallbacks[id] = callback : callback();
                },
                abort: function() {
                    callback && callback(undefined, !0);
                }
            };
        }
    });
    function createStandardXHR() {
        try {
            return new window.XMLHttpRequest;
        } catch (e) {}
    }
    function createActiveXHR() {
        try {
            return new window.ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {}
    }
    jQuery.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        
contents: {
            script: /(?:java|ecma)script/
        },
        converters: {
            "text script": function(text) {
                return jQuery.globalEval(text), text;
            }
        }
    }), jQuery.ajaxPrefilter("script", function(s) {
        s.cache === undefined && (s.cache = !1), s.crossDomain && (s.type = "GET", s.global = !1);
    }), jQuery.ajaxTransport("script", function(s) {
        if (s.crossDomain) {
            var script, head = document.head || jQuery("head")[0] || document.documentElement;
            return {
                send: function(_, callback) {
                    script = document.createElement("script"), script.async = !0, s.scriptCharset && (script.charset = s.scriptCharset), script.src = s.url, script.onload = script.onreadystatechange = function(_, isAbort) {
                        if (isAbort || !script.readyState || /loaded|complete/.test(script.readyState)) script.onload = script.onreadystatechange = null, script.parentNode && 
script.parentNode.removeChild(script), script = null, isAbort || callback(200, "success");
                    }, head.insertBefore(script, head.firstChild);
                },
                abort: function() {
                    script && script.onload(undefined, !0);
                }
            };
        }
    });
    var oldCallbacks = [], rjsonp = /(=)\?(?=&|$)|\?\?/;
    jQuery.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function() {
            var callback = oldCallbacks.pop() || jQuery.expando + "_" + nonce++;
            return this[callback] = !0, callback;
        }
    }), jQuery.ajaxPrefilter("json jsonp", function(s, originalSettings, jqXHR) {
        var callbackName, overwritten, responseContainer, jsonProp = s.jsonp !== !1 && (rjsonp.test(s.url) ? "url" : typeof s.data == "string" && !(s.contentType || "").indexOf("application/x-www-form-urlencoded") && rjsonp.test(s.data) && "data");
        if (jsonProp || s.dataTypes[0] === "jsonp") return callbackName = 
s.jsonpCallback = jQuery.isFunction(s.jsonpCallback) ? s.jsonpCallback() : s.jsonpCallback, jsonProp ? s[jsonProp] = s[jsonProp].replace(rjsonp, "$1" + callbackName) : s.jsonp !== !1 && (s.url += (rquery.test(s.url) ? "&" : "?") + s.jsonp + "=" + callbackName), s.converters["script json"] = function() {
            return responseContainer || jQuery.error(callbackName + " was not called"), responseContainer[0];
        }, s.dataTypes[0] = "json", overwritten = window[callbackName], window[callbackName] = function() {
            responseContainer = arguments;
        }, jqXHR.always(function() {
            window[callbackName] = overwritten, s[callbackName] && (s.jsonpCallback = originalSettings.jsonpCallback, oldCallbacks.push(callbackName)), responseContainer && jQuery.isFunction(overwritten) && overwritten(responseContainer[0]), responseContainer = overwritten = undefined;
        }), "script";
    }), jQuery.parseHTML = function(data, context, keepScripts) {
        if (!data || typeof 
data != "string") return null;
        typeof context == "boolean" && (keepScripts = context, context = !1), context = context || document;
        var parsed = rsingleTag.exec(data), scripts = !keepScripts && [];
        return parsed ? [ context.createElement(parsed[1]) ] : (parsed = jQuery.buildFragment([ data ], context, scripts), scripts && scripts.length && jQuery(scripts).remove(), jQuery.merge([], parsed.childNodes));
    };
    var _load = jQuery.fn.load;
    jQuery.fn.load = function(url, params, callback) {
        if (typeof url != "string" && _load) return _load.apply(this, arguments);
        var selector, response, type, self = this, off = url.indexOf(" ");
        return off >= 0 && (selector = jQuery.trim(url.slice(off, url.length)), url = url.slice(0, off)), jQuery.isFunction(params) ? (callback = params, params = undefined) : params && typeof params == "object" && (type = "POST"), self.length > 0 && jQuery.ajax({
            url: url,
            type: type,
            
dataType: "html",
            data: params
        }).done(function(responseText) {
            response = arguments, self.html(selector ? jQuery("<div>").append(jQuery.parseHTML(responseText)).find(selector) : responseText);
        }).complete(callback && function(jqXHR, status) {
            self.each(callback, response || [ jqXHR.responseText, status, jqXHR ]);
        }), this;
    }, jQuery.expr.filters.animated = function(elem) {
        return jQuery.grep(jQuery.timers, function(fn) {
            return elem === fn.elem;
        }).length;
    };
    var docElem = window.document.documentElement;
    function getWindow(elem) {
        return jQuery.isWindow(elem) ? elem : elem.nodeType === 9 ? elem.defaultView || elem.parentWindow : !1;
    }
    jQuery.offset = {
        setOffset: function(elem, options, i) {
            var curPosition, curLeft, curCSSTop, curTop, curOffset, curCSSLeft, calculatePosition, position = jQuery.css(elem, "position"), curElem = jQuery(elem), props = 
{};
            position === "static" && (elem.style.position = "relative"), curOffset = curElem.offset(), curCSSTop = jQuery.css(elem, "top"), curCSSLeft = jQuery.css(elem, "left"), calculatePosition = (position === "absolute" || position === "fixed") && jQuery.inArray("auto", [ curCSSTop, curCSSLeft ]) > -1, calculatePosition ? (curPosition = curElem.position(), curTop = curPosition.top, curLeft = curPosition.left) : (curTop = parseFloat(curCSSTop) || 0, curLeft = parseFloat(curCSSLeft) || 0), jQuery.isFunction(options) && (options = options.call(elem, i, curOffset)), options.top != null && (props.top = options.top - curOffset.top + curTop), options.left != null && (props.left = options.left - curOffset.left + curLeft), "using" in options ? options.using.call(elem, props) : curElem.css(props);
        }
    }, jQuery.fn.extend({
        offset: function(options) {
            if (arguments.length) return options === undefined ? this : this.each(function(i) {
                jQuery.offset
.setOffset(this, options, i);
            });
            var docElem, win, box = {
                top: 0,
                left: 0
            }, elem = this[0], doc = elem && elem.ownerDocument;
            if (!doc) return;
            return docElem = doc.documentElement, jQuery.contains(docElem, elem) ? (typeof elem.getBoundingClientRect !== strundefined && (box = elem.getBoundingClientRect()), win = getWindow(doc), {
                top: box.top + (win.pageYOffset || docElem.scrollTop) - (docElem.clientTop || 0),
                left: box.left + (win.pageXOffset || docElem.scrollLeft) - (docElem.clientLeft || 0)
            }) : box;
        },
        position: function() {
            if (!this[0]) return;
            var offsetParent, offset, parentOffset = {
                top: 0,
                left: 0
            }, elem = this[0];
            return jQuery.css(elem, "position") === "fixed" ? offset = elem.getBoundingClientRect() : (offsetParent = this.offsetParent(), offset = 
this.offset(), jQuery.nodeName(offsetParent[0], "html") || (parentOffset = offsetParent.offset()), parentOffset.top += jQuery.css(offsetParent[0], "borderTopWidth", !0), parentOffset.left += jQuery.css(offsetParent[0], "borderLeftWidth", !0)), {
                top: offset.top - parentOffset.top - jQuery.css(elem, "marginTop", !0),
                left: offset.left - parentOffset.left - jQuery.css(elem, "marginLeft", !0)
            };
        },
        offsetParent: function() {
            return this.map(function() {
                var offsetParent = this.offsetParent || docElem;
                while (offsetParent && !jQuery.nodeName(offsetParent, "html") && jQuery.css(offsetParent, "position") === "static") offsetParent = offsetParent.offsetParent;
                return offsetParent || docElem;
            });
        }
    }), jQuery.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, function(method, prop) {
        var top = /Y/.test(prop);
        
jQuery.fn[method] = function(val) {
            return access(this, function(elem, method, val) {
                var win = getWindow(elem);
                if (val === undefined) return win ? prop in win ? win[prop] : win.document.documentElement[method] : elem[method];
                win ? win.scrollTo(top ? jQuery(win).scrollLeft() : val, top ? val : jQuery(win).scrollTop()) : elem[method] = val;
            }, method, val, arguments.length, null);
        };
    }), jQuery.each([ "top", "left" ], function(i, prop) {
        jQuery.cssHooks[prop] = addGetHookIf(support.pixelPosition, function(elem, computed) {
            if (computed) return computed = curCSS(elem, prop), rnumnonpx.test(computed) ? jQuery(elem).position()[prop] + "px" : computed;
        });
    }), jQuery.each({
        Height: "height",
        Width: "width"
    }, function(name, type) {
        jQuery.each({
            padding: "inner" + name,
            content: type,
            "": "outer" + name
        }
, function(defaultExtra, funcName) {
            jQuery.fn[funcName] = function(margin, value) {
                var chainable = arguments.length && (defaultExtra || typeof margin != "boolean"), extra = defaultExtra || (margin === !0 || value === !0 ? "margin" : "border");
                return access(this, function(elem, type, value) {
                    var doc;
                    return jQuery.isWindow(elem) ? elem.document.documentElement["client" + name] : elem.nodeType === 9 ? (doc = elem.documentElement, Math.max(elem.body["scroll" + name], doc["scroll" + name], elem.body["offset" + name], doc["offset" + name], doc["client" + name])) : value === undefined ? jQuery.css(elem, type, extra) : jQuery.style(elem, type, value, extra);
                }, type, chainable ? margin : undefined, chainable, null);
            };
        });
    }), jQuery.fn.size = function() {
        return this.length;
    }, jQuery.fn.andSelf = jQuery.fn.addBack, typeof define == "function" && define.amd && 
define("jquery", [], function() {
        return jQuery;
    });
    var _jQuery = window.jQuery, _$ = window.$;
    return jQuery.noConflict = function(deep) {
        return window.$ === jQuery && (window.$ = _$), deep && window.jQuery === jQuery && (window.jQuery = _jQuery), jQuery;
    }, typeof noGlobal === strundefined && (window.jQuery = window.$ = jQuery), jQuery;
}), function(global, factory) {
    typeof exports == "object" && exports ? factory(exports) : typeof define == "function" && define.amd ? define("mustache", [ "exports" ], factory) : factory(global.Mustache = {});
}(this, function(mustache) {
    var Object_toString = Object.prototype.toString, isArray = Array.isArray || function(object) {
        return Object_toString.call(object) === "[object Array]";
    };
    function isFunction(object) {
        return typeof object == "function";
    }
    function escapeRegExp(string) {
        return string.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
    }
    var RegExp_test = 
RegExp.prototype.test;
    function testRegExp(re, string) {
        return RegExp_test.call(re, string);
    }
    var nonSpaceRe = /\S/;
    function isWhitespace(string) {
        return !testRegExp(nonSpaceRe, string);
    }
    var entityMap = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#39;",
        "/": "&#x2F;"
    };
    function escapeHtml(string) {
        return String(string).replace(/[&<>"'\/]/g, function(s) {
            return entityMap[s];
        });
    }
    var whiteRe = /\s*/, spaceRe = /\s+/, equalsRe = /\s*=/, curlyRe = /\s*\}/, tagRe = /#|\^|\/|>|\{|&|=|!/;
    function parseTemplate(template, tags) {
        if (!template) return [];
        var sections = [], tokens = [], spaces = [], hasTag = !1, nonSpace = !1;
        function stripSpace() {
            if (hasTag && !nonSpace) while (spaces.length) delete tokens[spaces.pop()]; else spaces = [];
            hasTag = !1, nonSpace = !1;
        }
        
var openingTagRe, closingTagRe, closingCurlyRe;
        function compileTags(tags) {
            typeof tags == "string" && (tags = tags.split(spaceRe, 2));
            if (!isArray(tags) || tags.length !== 2) throw new Error("Invalid tags: " + tags);
            openingTagRe = new RegExp(escapeRegExp(tags[0]) + "\\s*"), closingTagRe = new RegExp("\\s*" + escapeRegExp(tags[1])), closingCurlyRe = new RegExp("\\s*" + escapeRegExp("}" + tags[1]));
        }
        compileTags(tags || mustache.tags);
        var scanner = new Scanner(template), start, type, value, chr, token, openSection;
        while (!scanner.eos()) {
            start = scanner.pos, value = scanner.scanUntil(openingTagRe);
            if (value) for (var i = 0, valueLength = value.length; i < valueLength; ++i) chr = value.charAt(i), isWhitespace(chr) ? spaces.push(tokens.length) : nonSpace = !0, tokens.push([ "text", chr, start, start + 1 ]), start += 1, chr === "\n" && stripSpace();
            if (!scanner.scan(openingTagRe
)) break;
            hasTag = !0, type = scanner.scan(tagRe) || "name", scanner.scan(whiteRe), type === "=" ? (value = scanner.scanUntil(equalsRe), scanner.scan(equalsRe), scanner.scanUntil(closingTagRe)) : type === "{" ? (value = scanner.scanUntil(closingCurlyRe), scanner.scan(curlyRe), scanner.scanUntil(closingTagRe), type = "&") : value = scanner.scanUntil(closingTagRe);
            if (!scanner.scan(closingTagRe)) throw new Error("Unclosed tag at " + scanner.pos);
            token = [ type, value, start, scanner.pos ], tokens.push(token);
            if (type === "#" || type === "^") sections.push(token); else if (type === "/") {
                openSection = sections.pop();
                if (!openSection) throw new Error('Unopened section "' + value + '" at ' + start);
                if (openSection[1] !== value) throw new Error('Unclosed section "' + openSection[1] + '" at ' + start);
            } else type === "name" || type === "{" || type === "&" ? nonSpace = !0 : type === "=" && 
compileTags(value);
        }
        openSection = sections.pop();
        if (openSection) throw new Error('Unclosed section "' + openSection[1] + '" at ' + scanner.pos);
        return nestTokens(squashTokens(tokens));
    }
    function squashTokens(tokens) {
        var squashedTokens = [], token, lastToken;
        for (var i = 0, numTokens = tokens.length; i < numTokens; ++i) token = tokens[i], token && (token[0] === "text" && lastToken && lastToken[0] === "text" ? (lastToken[1] += token[1], lastToken[3] = token[3]) : (squashedTokens.push(token), lastToken = token));
        return squashedTokens;
    }
    function nestTokens(tokens) {
        var nestedTokens = [], collector = nestedTokens, sections = [], token, section;
        for (var i = 0, numTokens = tokens.length; i < numTokens; ++i) {
            token = tokens[i];
            switch (token[0]) {
              case "#":
              case "^":
                collector.push(token), sections.push(token), collector = token
[4] = [];
                break;
              case "/":
                section = sections.pop(), section[5] = token[2], collector = sections.length > 0 ? sections[sections.length - 1][4] : nestedTokens;
                break;
              default:
                collector.push(token);
            }
        }
        return nestedTokens;
    }
    function Scanner(string) {
        this.string = string, this.tail = string, this.pos = 0;
    }
    Scanner.prototype.eos = function() {
        return this.tail === "";
    }, Scanner.prototype.scan = function(re) {
        var match = this.tail.match(re);
        if (!match || match.index !== 0) return "";
        var string = match[0];
        return this.tail = this.tail.substring(string.length), this.pos += string.length, string;
    }, Scanner.prototype.scanUntil = function(re) {
        var index = this.tail.search(re), match;
        switch (index) {
          case -1:
            match = this.tail, this.tail = "";
            break;
          
case 0:
            match = "";
            break;
          default:
            match = this.tail.substring(0, index), this.tail = this.tail.substring(index);
        }
        return this.pos += match.length, match;
    };
    function Context(view, parentContext) {
        this.view = view == null ? {} : view, this.cache = {
            ".": this.view
        }, this.parent = parentContext;
    }
    Context.prototype.push = function(view) {
        return new Context(view, this);
    }, Context.prototype.lookup = function(name) {
        var cache = this.cache, value;
        if (name in cache) value = cache[name]; else {
            var context = this, names, index;
            while (context) {
                if (name.indexOf(".") > 0) {
                    value = context.view, names = name.split("."), index = 0;
                    while (value != null && index < names.length) value = value[names[index++]];
                } else typeof context.view == "object" && (value = context
.view[name]);
                if (value != null) break;
                context = context.parent;
            }
            cache[name] = value;
        }
        return isFunction(value) && (value = value.call(this.view)), value;
    };
    function Writer() {
        this.cache = {};
    }
    Writer.prototype.clearCache = function() {
        this.cache = {};
    }, Writer.prototype.parse = function(template, tags) {
        var cache = this.cache, tokens = cache[template];
        return tokens == null && (tokens = cache[template] = parseTemplate(template, tags)), tokens;
    }, Writer.prototype.render = function(template, view, partials) {
        var tokens = this.parse(template), context = view instanceof Context ? view : new Context(view);
        return this.renderTokens(tokens, context, partials, template);
    }, Writer.prototype.renderTokens = function(tokens, context, partials, originalTemplate) {
        var buffer = "", self = this;
        function subRender(template) {
            
return self.render(template, context, partials);
        }
        var token, value;
        for (var i = 0, numTokens = tokens.length; i < numTokens; ++i) {
            token = tokens[i];
            switch (token[0]) {
              case "#":
                value = context.lookup(token[1]);
                if (!value) continue;
                if (isArray(value)) for (var j = 0, valueLength = value.length; j < valueLength; ++j) buffer += this.renderTokens(token[4], context.push(value[j]), partials, originalTemplate); else if (typeof value == "object" || typeof value == "string") buffer += this.renderTokens(token[4], context.push(value), partials, originalTemplate); else if (isFunction(value)) {
                    if (typeof originalTemplate != "string") throw new Error("Cannot use higher-order sections without the original template");
                    value = value.call(context.view, originalTemplate.slice(token[3], token[5]), subRender), value != null && (buffer += value);
                
} else buffer += this.renderTokens(token[4], context, partials, originalTemplate);
                break;
              case "^":
                value = context.lookup(token[1]);
                if (!value || isArray(value) && value.length === 0) buffer += this.renderTokens(token[4], context, partials, originalTemplate);
                break;
              case ">":
                if (!partials) continue;
                value = isFunction(partials) ? partials(token[1]) : partials[token[1]], value != null && (buffer += this.renderTokens(this.parse(value), context, partials, value));
                break;
              case "&":
                value = context.lookup(token[1]), value != null && (buffer += value);
                break;
              case "name":
                value = context.lookup(token[1]), value != null && (buffer += mustache.escape(value));
                break;
              case "text":
                buffer += token[1];
            }
        }
        return buffer
;
    }, mustache.name = "mustache.js", mustache.version = "1.0.0", mustache.tags = [ "{{", "}}" ];
    var defaultWriter = new Writer;
    mustache.clearCache = function() {
        return defaultWriter.clearCache();
    }, mustache.parse = function(template, tags) {
        return defaultWriter.parse(template, tags);
    }, mustache.render = function(template, view, partials) {
        return defaultWriter.render(template, view, partials);
    }, mustache.to_html = function(template, view, partials, send) {
        var result = mustache.render(template, view, partials);
        if (!isFunction(send)) return result;
        send(result);
    }, mustache.escape = escapeHtml, mustache.Scanner = Scanner, mustache.Context = Context, mustache.Writer = Writer;
}), define("helper", [ "jquery" ], function($) {
    var Helper = function() {};
    return Helper.prototype.route = function(path) {
        window.location.href = path;
    }, Helper.prototype.getMustacheTemplate = function(config) {
        
var urlBase = this.urlBase, templates = localStorage.getItem("mustache/template");
        templates ? templates = JSON.parse(templates) : templates = {}, templates.hasOwnProperty(config.template) ? config.success(JSON.parse(templates[config.template])) : $.ajax({
            url: urlBase("mustache/" + config.template + ".mst"),
            type: "get",
            dataType: "text",
            complete: function(response) {
                templates[config.template] = JSON.stringify(response.responseText), localStorage.setItem("mustache/template", JSON.stringify(templates));
            },
            success: config.success
        });
    }, Helper.prototype.urlBase = function(append) {
        return localStorage.getItem("url/base") || localStorage.setItem("url/base", $("[data-urlBase]").attr("data-urlBase")), localStorage.getItem("url/base") + append;
    }, new Helper;
}), define("admin/feedbackStream", [ "jquery", "mustache", "helper" ], function($, mustache, helper) {
    var FeedbackStream = 
function() {};
    return FeedbackStream.prototype.createMessage = function(config) {
        var newMessage;
        if (!config.message) return;
        helper.getMustacheTemplate({
            template: "admin/feedback",
            success: function(template) {
                $(".js-feedback-stream-position").prepend(mustache.render(template, config));
                var timer = setTimeout(function() {
                    $(".js-feedback-stream-single").first().addClass("is-removed"), $(".js-feedback-stream-single").on("animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd", function(event) {
                        $(this).remove();
                    });
                }, 5e3);
                $(".js-feedback-stream-single").off("click.feedback-stream").on("click.feedback-stream", function(event) {
                    event.preventDefault(), $(this).addClass("is-removed"), $(".js-feedback-stream-single").on("animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd", 
function(event) {
                        $(this).remove();
                    });
                });
            }
        });
    }, new FeedbackStream;
}), define("admin-main", [ "jquery", "admin/feedbackStream" ], function($, feedbackStream) {
    $.ajaxSetup({
        timeout: 1e4,
        cache: !1
    }), feedbackStream.createMessage(feedback);
    var moduleName = $("[data-moduleName]").attr("data-moduleName");
    if (!moduleName) return;
    require([ "admin/" + moduleName ]);
});;